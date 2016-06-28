CKEDITOR.dialog.add( 'myDialog', function( editor )
{
    return {
        title : '前言',
        resizable: CKEDITOR.DIALOG_RESIZE_BOTH,
        minWidth : 400,
        minHeight : 200,
        contents : [
            {
                id : 'preface',
                name : 'preface',
                label : '前言',
                title : '前言',
                elements :
                [
                    {
                        type: 'textarea',
                        required: true,
                        style: 'width:100%;height:100%',
                        rows: 6,
                        label : '前言',
                        id : 'preface'
                    }
                ],
                onOk : function(){
                    var preface = this.getValueOf('preface', 'preface');
                    editor.insertHtml(preface);
                },
            }
        ]
    };
});