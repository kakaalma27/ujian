import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';

const editorElement = document.querySelector('#editor');

ClassicEditor
    .create(editorElement)
    .catch(error => {
        console.error(error);
    });
