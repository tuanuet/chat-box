import {call, put,} from 'redux-saga/effects';
import {addMessage, setImage, updateMessageMetadata} from '../../actions/action';
import {fetchMetadataSuccess, fetchMetadataFailure,uploadImageFailure,uploadImageSuccess} from './actions';
import {FETCH_META, UPLOAD_IMAGE,} from './constants';
import {API_GET_METADATA_URL, API_UPLOAD_IMAGE_URL} from '../../constants/Server';
import {takeLatest} from "redux-saga";

function fetchMetadata(link) {
    return fetch(API_GET_METADATA_URL+ link)
        .then(resolve => resolve.json());
}
function uploadImage(form) {
    return fetch(API_UPLOAD_IMAGE_URL, {
        method: 'post',
        body: form
    }).then(resolve => resolve.json());
}

function* handleFetMetaLink(action) {
    try {
        const {meta} = yield call(fetchMetadata, action.link);
        yield put(fetchMetadataSuccess({meta}));
        yield put(updateMessageMetadata(action.content, meta.title, meta.description, meta.image));
    } catch (err) {
        console.error('FETCH META DATA FAIL!', err.message);
        yield put(fetchMetadataFailure(err.message));
    }
}

function* handleUploadImage(action) {
    try {
        const message = yield uploadImage(action.form);
        yield put(uploadImageSuccess());

        let date = new Date().getHours() + ':' + new Date().getMinutes();
        yield put(addMessage('self','', {type: 103, content: message.content}, date));
        yield put(setImage({url : message.content,time : new Date()}));
    }catch(err) {
        yield put(uploadImageFailure(err.message));
    }
}

export function* uploadImageSaga() {
    yield takeLatest(UPLOAD_IMAGE,handleUploadImage);
}
export function* fetchMetaLinkSaga() {
    yield takeLatest(FETCH_META, handleFetMetaLink);
}
