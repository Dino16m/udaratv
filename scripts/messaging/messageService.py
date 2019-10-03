from bottle import run, response, request, route
import json
from udaraTele import sendMessage



@route('/sendmessage', method='POST')
def sendMsg():
    formdata = request.forms.get('payload')
    payload = json.loads(formdata)
    sender = request.query.sender
    status = (lambda: sendMessage(payload, sender), lambda: sendMessage(payload))[sender == '']()
    return status


run(host='localhost', port=8085, reloader=True, debug=True)
