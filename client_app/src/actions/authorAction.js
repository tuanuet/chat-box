import * as types from './actionTypes';
import courseApi from '../api/mockAuthorApi';
import {beginAjaxCall} from "./ajaxStatusAction";

export function loadAuthorsSuccess(authors) {
  return {type: types.LOAD_AUTHORS_SUCCESS, authors};
}

/**nap du lieu khi load page*/
export function loadAuthors() {
  return function (dispatch) {
    dispatch(beginAjaxCall());
    return courseApi.getAllAuthors().then(authors => {
      dispatch(loadAuthorsSuccess(authors));
    }).catch(error => {
      throw error;
    });
  };
}
