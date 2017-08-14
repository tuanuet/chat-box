import { call, put } from 'redux-saga/effects';
import {API_CREATE_TOKEN_URL} from '../../constants/Server';
import {hideForm, setCustomerInfo, setRoomInfo} from '../../actions/action';
import {takeLatest} from 'redux-saga';
import {REGISTER_TOKEN} from './constants';
import {registerTokenFailure, registerTokenSuccess} from './actions';

function fetchToken(params) {
    const postParams =
        Object.keys(params).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(params[key])).join('&');

    return fetch(API_CREATE_TOKEN_URL, {
        method: 'POST',
        mode: 'cors',
        body: postParams,
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded ',
        })
    }).then( resolve => resolve.json());
}

// Individual exports for testing
function* handleFetchToken(action) {
    try{
        const {customer,room,token} = yield call(fetchToken,action.params);
        yield put(registerTokenSuccess({customer,room,token}));


        //store JWT Token to browser session storage
        //If you use localStorage instead of sessionStorage, then this w/
        //persisted across tabs and new windows.
        //sessionStorage = persisted only in current tab
        sessionStorage.setItem('jwtToken', token);

        const {id,name,email,phone} = customer;
        yield put(setCustomerInfo(id,name,email,phone));
        yield put(setRoomInfo(room));
        yield put(hideForm(true));

    }catch (err) {
        console.log(err.message)
        put(registerTokenFailure(err.message));
    }

}

function* fetchTokenSagas() {
    console.log('chay vao saga')
    yield* takeLatest(REGISTER_TOKEN,handleFetchToken);
}

// bar.js
export default fetchTokenSagas;

