var fs = require( 'fs' );
var stripComments = require( 'strip-json-comments' )

// assumes this is run via node.
function usage( message ) {
    if( message ) {
        console.log( message );
    }
    console.log( "USAGE: " + process.argv[1] + " <path-to-schema> <path-to-json>" );
}

// unclear to me yet which library to bet on, if not something else entirely.

function validate_with_jsonschema( schema_object, json_object ) {
    var Validator = require('jsonschema').Validator;
    var v = new Validator();
    var r = v.validate( json_object, schema_object );
    if( r.errors && r.errors.length ) {
        var err = "(jsonschema) VALIDATION FAILED: " + r.errors;
        throw err;
    }
}

function validate_with_tv4( schema_object, json_object ) {
    var tv4 = require( 'tv4' );
    var validation_result = tv4.validate( json_object, schema_object );
    if( ! validation_result ) {
        var err = "(tv4) VALIDATION FAILED: " + JSON.stringify( tv4.error );
        throw err;
    }
}

function validate( schema_object, json_object ) {
    validate_with_jsonschema( schema_object, json_object );
    validate_with_tv4( schema_object, json_object );
    console.log( "Passed." );
}

function json_parse( msg, json_buf ) {
    try {
        var json_str = stripComments( json_buf.toString( 'utf8' ) );
        var jsonlint = require("jsonlint");
        jsonlint.parse( json_str );
        return JSON.parse( json_str );
    }
    catch( e ) {
        var err = "FAILED TO PARSE INPUT JSON: " + msg + ", " + e.message;
        throw err;
    }
}

function run( json_schema_path, json_data_path ) {
    fs.readFile( json_schema_path, function( err, schema_buf ) {
        if( err ) { throw err; }
        var schema_object = json_parse( "schema input", schema_buf, 'utf8' );
        fs.readFile( json_data_path, function( err, json_buf ) {
            if( err ) { throw err; }
            var json_object = json_parse( "json input", json_buf, 'utf8' );
            validate( schema_object, json_object );
        } );
    } );
}

var json_schema_path = process.argv[2];
var json_data_path = process.argv[3];
if( ! json_schema_path || ! json_data_path ) {
    usage( "ERROR: bad/missing argument" );
}
else {
    run( json_schema_path, json_data_path );
}
