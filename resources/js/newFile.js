import ClassicEditor from '@ckeditor/ckeditor5-alignment';
import { editorElement } from './app';

ClassicEditor
    .create(editorElement)
    .catch(error => {
        console.error(error);
    });
