(function() {
    tinymce.create('tinymce.plugins.Currency', {
        init: function(ed, url) {

            ed.addButton('euroSign', {
                title: 'Insert Euro Sign',
                cmd: 'euroSign',
                image: url + '/euroSign.png'
            });

            ed.addButton('poundSign', {
                title: 'Insert Pound Sign',
                cmd: 'poundSign',
                image: url + '/poundSign.png'
            });

            // ed.addButton('vSign', {
            //     title: 'Insert V Sign in Circle',
            //     cmd: 'vSign',
            //     image: url + '/vSign.png'
            // });



            ed.addCommand('euroSign', function() {
                var selected_text = ed.selection.getContent();
                return_text = selected_text + '€';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            ed.addCommand('poundSign', function() {
                var selected_text = ed.selection.getContent();
                return_text = selected_text + '£';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            // ed.addCommand('vSign', function() {
            //     // var selected_text = ed.selection.getContent();
            //     return_text = '<i class="fa fa-check-circle-o">&nbsp;</i>';
            //     ed.execCommand('mceInsertContent', 0, return_text);
            // });



        }


    });
    // Register plugin
    tinymce.PluginManager.add('Currency', tinymce.plugins.Currency);
})();