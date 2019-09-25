from telethon.sync import TelegramClient
import json
import sys
from urllib.parse import unquote_plus


api_id = 872129
api_hash = '1390959115b339a8e20294e3591a8b41'

def getChannels(client):
    channels = {d.entity.username: d.entity
                for d in client.get_dialogs()
                if d.is_channel}
    return channels

def getRecipients(client, recipients):
	channels = getChannels(client)
	valid_channel_recipients = [recipient for recipient in recipients if recipient is not None and recipient in channels.keys()]
	invalid_channel_recipients = set(recipients) - set(valid_channel_recipients)
	invalid_channel_recipients = list(invalid_channel_recipients)
	try:
		non_channel_recipients = (lambda: client.get_entity(invalid_channel_recipients), lambda: [])[not invalid_channel_recipients]()
	except Exception:
		pass
	return valid_channel_recipients + non_channel_recipients

def constructMessage(msg_dict):
	trailer_link = msg_dict['trailer_link']
	download_link = msg_dict['download_link']
	description = unquote_plus(msg_dict['description'])
	name = unquote_plus(msg_dict['name'])
	message = "<a href='" + trailer_link + "'>_</a> <br><b>" + name.capitalize() + " </b><br><br> " + description + " <a href='" + download_link + "'><b> Download " + name + "</b></a>"
	return message

def sendMessage(payload, session='dynasties'):
	with TelegramClient(session, api_id, api_hash) as client:
		recipients = payload['recipients']
		valid_recipients = getRecipients(client, recipients)
		if not valid_recipients:
			return {'status': False, 'error': 'All the recipients for this broadcast are invalid'}
		for valid_recipient in valid_recipients:
			messages = payload['messages']
			for message in messages:
				message = constructMessage(message)
				client.send_message(valid_recipient, message, parse_mode='html')
		return {'status': True}

def finalResolve(dictionary):
	return json.dumps(dictionary)

def main():
	args = sys.argv[1]
	sender = (lambda: None, lambda: sys.argv[2])[len(sys.argv) > 2]()
	payload = json.loads(args)
	if not payload:
		return finalResolve({'status': False, 'error': 'invalid payload'})
	response = (lambda: sendMessage(payload, sender), lambda: sendMessage(payload))[sender is None]()
	return finalResolve(response)

if __name__ == '__main__':
	if not len(sys.argv) > 1:
		return_json = finalResolve({'status': False, 'error': 'invalid payload'})
		print(return_json)
	if len(sys.argv) > 1:
		print(main())