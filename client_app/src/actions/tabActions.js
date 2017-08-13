import * as types from './actionTypes';
import roomApi from '../api/roomApi';

export function createTab(room) {
    return {type: types.CREATE_TAB, room};
}

export function deleteTab (tab) {
    return {type: types.DELETE_TAB, tab};
}

