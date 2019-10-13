Centauri.Component.RTE = function() {
    if($(".ck.ck-reset_all.ck-body.ck-rounded-corners").length) {
        $(".ck.ck-reset_all.ck-body.ck-rounded-corners").remove();
    }

    var textareas = document.getElementsByClassName("centauri-textarea");

    for(var i = 0; i < textareas.length; i++) {
        if(!textareas[i].classList.contains("centauri-rte-initialized")) {
            textareas[i].classList.add("centauri-rte-initialized");

            ClassicEditor
            .create(textareas[i], {
                toolbar: [
                    'heading',

                    '|',

                    'bold',
                    'italic',
                    'link',

                    'bulletedList',
                    'numberedList',

                    '|',

                    'blockQuote',
                    'imageUpload',
                    'mediaEmbed',

                    '|',

                    'insertTable',

                    '|',

                    'undo',
                    'redo'
                ],

                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                }
            })

            .catch(error => {
                console.error(error);
            });
        }
    }
};
