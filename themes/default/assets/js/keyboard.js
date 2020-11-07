/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        function display_keyboards() {
           
            $('.kb-text').keyboard({
                autoAccept: true,
                alwaysOpen: false,
                openOn: 'focus',
                usePreview: false,
                layout: 'custom',
                //layout: 'qwerty',
                display: {
                    'bksp': "\u2190",
                    'accept': 'Accept',
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

            $('.kb-pad').keyboard({
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
        
        $.extend($.keyboard.keyaction, {
            enter: function (base) {
                base.accept();
            }
        });
        
        /*$(document).on('focus','.close_register_input',function(){
           
            display_keyboards();
        });
        
        $(document).on('focus','.curr',function(){
            $(this).keyboard({
                restrictInput: true,
                preventPaste: true,
                autoAccept: true,
                alwaysOpen: false,
                openOn: 'click',
                usePreview: false,
                layout: 'costom',
                display: {
                    'b': '\u2190:Backspace',
                },
                customLayout: {
                    'default': [
                        '1 2 3 {b}',
                        '4 5 6 . {clear}',
                        '7 8 9 0 %',
                        '{accept} {cancel}'
                    ]
                }
            });   
        });
        */
        $(document).bind('keyup blur','.cardno',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^0-9]+/i, '') ); }
        );

     
        
//    $(document).on('focus','.input-xs',function(){
//        $(this).keyboard({
//            autoAccept: true,
//            alwaysOpen: false,
//            openOn: 'focus',
//            usePreview: false,
//            layout: 'custom',
//            //layout: 'qwerty',
//            display: {
//                'bksp': "\u2190",
//                'accept': 'accept',
//                'default': 'ABC',
//                'meta1': '123',
//                'meta2': '#+='
//            },
//            customLayout: {
//                'default': [
//                    'q w e r t y u i o p {bksp}',
//                    'a s d f g h j k l {enter}',
//                    '{s} z x c v b n m , . {s}',
//                    '{meta1} {space} {cancel} {accept}'
//                ],
//                'shift': [
//                    'Q W E R T Y U I O P {bksp}',
//                    'A S D F G H J K L {enter}',
//                    '{s} Z X C V B N M / ? {s}',
//                    '{meta1} {space} {meta1} {accept}'
//                ],
//                'meta1': [
//                    '1 2 3 4 5 6 7 8 9 0 {bksp}',
//                    '- / : ; ( ) \u20ac & @ {enter}',
//                    '{meta2} . , ? ! \' " {meta2}',
//                    '{default} {space} {default} {accept}'
//                ],
//                'meta2': [
//                    '[ ] { } # % ^ * + = {bksp}',
//                    '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
//                    '{meta1} ~ . , ? ! \' " {meta1}',
//                    '{default} {space} {default} {accept}'
//                ]},
//                accepted : function(e, keyboard, el){ 
//                                $(this).trigger('navigate', 'enter');
//                                console.log(JSON.stringify(el.value));
//                                alert('The content "' + el.value + '" was accepted!');             
//                            }
//        });
//    });
    
    
