$(document).ready(function () {

     $( ".close_register_input" ).click(function() {
        
        if(!$('.ui-keyboard').is(":visible")){
            $('.close_register_input:not([readonly])').keyboard({
                layout : 'num',
                restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
                preventPaste : true,  // prevent ctrl-v and right click
                autoAccept : false,
                usePreview : false,
               accepted : function(e, keyboard, el){
                    keyboard.destroy();
                    return false;
                },
                canceled : function(e, keyboard, el){
                    keyboard.destroy();
                    return false;
                }
            });
        }
    });
    
    $('.close_register_input:not([readonly])').keyboard({
        layout : 'num',
        restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste : true,  // prevent ctrl-v and right click
        autoAccept : false,
        usePreview : false,
        accepted : function(e, keyboard, el){
            keyboard.destroy();
            return false;
        },
        canceled : function(e, keyboard, el){
            keyboard.destroy();
            return false;
        }
    });

     $( ".keyboard-text" ).click(function() {

        if(!$('.ui-keyboard').is(":visible")){
            $('.keyboard-text').keyboard({
                autoAccept: true,
                alwaysOpen: false,
                openOn: 'focus',
                usePreview: false,
                layout: 'custom',
                accepted : function(e, keyboard, el){
                    keyboard.destroy();
                    return false;
                },
                canceled : function(e, keyboard, el){
                    keyboard.destroy();
                    return false;
                },
                //layout: 'qwerty',
                display: {
                    'bksp': "\u2190",
                    'accept': 'accept',
                    'default': 'ABC',
                    'meta1': '123',
                    'meta2': '#+='
                },
                customLayout: {
                    'default': [
                        'q w e r t y u i o p {bksp}',
                        'a s d f g h j k l {enter}',
                        '{s} z x c v b n m , . {s}',
                        '{meta1} {space} {cancel} {accept}'
                ],
                'shift': [
                    'Q W E R T Y U I O P {bksp}',
                    'A S D F G H J K L {enter}',
                    '{s} Z X C V B N M / ? {s}',
                    '{meta1} {space} {meta1} {accept}'
                ],
                'meta1': [
                    '1 2 3 4 5 6 7 8 9 0 {bksp}',
                    '- / : ; ( ) \u20ac & @ {enter}',
                    '{meta2} . , ? ! \' " {meta2}',
                    '{default} {space} {default} {accept}'
                ],
                'meta2': [
                    '[ ] { } # % ^ * + = {bksp}',
                    '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                    '{meta1} ~ . , ? ! \' " {meta1}',
                    '{default} {space} {default} {accept}'
                ]}
            });
        }
    });

    $('.keyboard-text').keyboard({
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'focus',
        usePreview: false,
        layout: 'custom',
        accepted : function(e, keyboard, el){
            keyboard.destroy();
            return false;
        },
        canceled : function(e, keyboard, el){
             //keyboard.close();
            //alert(1)
            keyboard.destroy();
            return false;
        },
        //layout: 'qwerty',
        display: {
            'bksp': "\u2190",
            'accept': 'accept',
            'default': 'ABC',
            'meta1': '123',
            'meta2': '#+='
        },
        customLayout: {
            'default': [
                'q w e r t y u i o p {bksp}',
                'a s d f g h j k l {enter}',
                '{s} z x c v b n m , . {s}',
                '{meta1} {space} {cancel} {accept}'
            ],
            'shift': [
                'Q W E R T Y U I O P {bksp}',
                'A S D F G H J K L {enter}',
                '{s} Z X C V B N M / ? {s}',
                '{meta1} {space} {meta1} {accept}'
            ],
            'meta1': [
                '1 2 3 4 5 6 7 8 9 0 {bksp}',
                '- / : ; ( ) \u20ac & @ {enter}',
                '{meta2} . , ? ! \' " {meta2}',
                '{default} {space} {default} {accept}'
            ],
            'meta2': [
                '[ ] { } # % ^ * + = {bksp}',
                '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                '{meta1} ~ . , ? ! \' " {meta1}',
                '{default} {space} {default} {accept}'
            ]}
        });
});
