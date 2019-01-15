(function( $ ) {

    var reader = {};
    var file = {};
    var slice_size = 1000 * 1024;

    function start_upload( event ) {
        event.preventDefault();

        reader = new FileReader();
        file = document.querySelector( '#dbi-file-upload' ).files[0];

        upload_file( 0 );
    }
    $( '#dbi-file-upload-submit' ).on( 'click', start_upload );

    function upload_file( start ) {

    }

})( jQuery );
//Now we can start working on the upload_file() function that will handle most of the heavy lifting. First we create a blob containing a small chunk of the file using the JavaScript slice() method:

function upload_file( start ) {
    var next_slice = start + slice_size + 1;
    var blob = file.slice( start, next_slice );
}
//We’ll also need to define a function within the upload_file() function that will run when the FileReader API has read from the file.

reader.onloadend = function( event ) {
    if ( event.target.readyState !== FileReader.DONE ) {
        return;
    }

    // At this point the file data is loaded to event.target.result
};
//Now we need to tell the FileReader API to read a portion of the file. We can do that by passing the blob of file data that we created to the FileReader object:

reader.readAsDataURL( blob );
//It’s worth noting that we’re using the FileReader.readAsDataURL() method of the FileReader object, instead of the FileReader.readAsText() or FileReader.readAsBinaryString() methods that are mentioned in the FileReader documentation.

//In this case the FileReader.readAsDataURL() method is much more reliable than the other methods because the contents of the file are read out as a Base64-encoded string as opposed to plain text or binary. This is important because a string containing plain text or binary will likely run into encoding or sanitization issues when sent to the server via AJAX. On the other hand, a Base64-encoded string will usually just contain the A-Z, a-z, and 0-9 characters, and is easy enough to decode with PHP or any other server-side language.

//Let’s fill out the rest of the function by adding the AJAX call that is responsible for POSTing the data to the server and recursively calling the upload_file() function again when the request has completed. Here’s what the upload_file() function looks like in it’s entirety:

function upload_file( start ) {
    var next_slice = start + slice_size + 1;
    var blob = file.slice( start, next_slice );

    reader.onloadend = function( event ) {
        if ( event.target.readyState !== FileReader.DONE ) {
            return;
        }

        $.ajax( {
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                action: 'dbi_upload_file',
                file_data: event.target.result,
                file: file.name,
                file_type: file.type,
                nonce: dbi_vars.upload_file_nonce
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR, textStatus, errorThrown );
            },
            success: function( data ) {
                var size_done = start + slice_size;
                var percent_done = Math.floor( ( size_done / file.size ) * 100 );

                if ( next_slice < file.size ) {
                    // Update upload progress
                    $( '#dbi-upload-progress' ).html( 'Uploading File - ' + percent_done + '%' );

                    // More to upload, call function recursively
                    upload_file( next_slice );
                } else {
                    // Update upload progress
                    $( '#dbi-upload-progress' ).html( 'Upload Complete!' );
                }
            }
        } );
    };

    reader.readAsDataURL( blob );
}