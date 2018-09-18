jQuery.extend({
    getValues: function(url) {
         var result = null;
        // dataGallery = ['sad','sadsa'];
        // $.get(url, function(data, status){
            // $.each(data, function(i, item) {
            //     dataGallery.push(new Array(item.title, item.id));
            //     //console.log(dataGallery);
            // });
        // });

        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(data) {
                result = data;
            }
        });
       return result;
    }
});

var results = $.getValues("/api/gallery");

CKEDITOR.plugins.add( 'abbr', {
    icons: 'abbr',
    init: function( editor ) {
        editor.addCommand( 'abbr', new CKEDITOR.dialogCommand( 'abbrDialog' ) );
        editor.ui.addButton( 'Abbr', {
            label: 'Insert Gallery',
            command: 'abbr',
            toolbar: 'insert'
        });

        CKEDITOR.dialog.add( 'abbrDialog', this.path + 'dialogs/gallery.js' );
    }
});