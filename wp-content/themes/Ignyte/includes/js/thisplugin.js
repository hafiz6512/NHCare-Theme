/* Example to add a button to the wordpress tinymce */
(function() {
    tinymce.create('tinymce.plugins.thisplugin', {
        init : function(ed, url) {
            ed.addButton('thisplugin', {
                title : 'Add a thisplugin',
                image : url+'/image.png',
                onclick : function() {
                     ed.selection.setContent('[thisplugin]' + ed.selection.getContent() + '[/thisplugin]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('thisplugin', tinymce.plugins.thisplugin);
})();