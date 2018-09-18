CKEDITOR.dialog.add( 'abbrDialog', function( editor ) {
    return {
        title: 'Insert Gallery',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-basic',
                label: 'Gallery',
                elements: [
                    {
                        type: 'select',
                        id: 'galleryid',
                        items: results,
                        label: 'Choose Gallery',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Please select gallery" )
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var gallery = "[gallery:" + dialog.getValueOf( 'tab-basic', 'galleryid' ) +"]";
            editor.insertHtml( gallery );
        }
    };
});