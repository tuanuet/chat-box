import ChatformSaga from './container/ChatformContainer/sagas';
import {
    fetchMetaLinkSaga,
    uploadImageSaga
} from './container/BottomBarContainer/sagas';
import {closeChat} from "./container/App/sagas";

import {fork} from 'redux-saga/effects';

export default function* rootSaga() {
    yield fork(ChatformSaga);
    yield fork(fetchMetaLinkSaga);
    yield fork(uploadImageSaga);
    yield fork(closeChat);

}