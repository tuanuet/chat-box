import * as types from './actionTypes';
import roomApi from '../api/roomApi';

export function loadRoomsSuccess(rooms) {
    return {type: types.LOAD_ROOMS_SUCCESS, rooms};
}

export function adminJoinRoom(room) {
    return {type: types.ADMIN_JOIN_ROOM, room};
}

export function adminJoinRoomSuccess(room) {
    return {type: types.ADMIN_JOIN_ROOM_SUCCESS, room};
}

export function addNewRoom(room) {
    return {type: types.ADD_NEW_ROOM, room}
}

/**
 * load all rooms of admin
 * @param adminId
 * @returns {Function}
 */
export function loadRooms(adminId) {
    return function (dispatch) {
        return roomApi.getAllRooms(adminId)
            .then(res => res.data)
            .then(rooms => {
                console.log("rooms from server: ");
                console.log(rooms);
                dispatch(loadRoomsSuccess(rooms));
            })
            .catch(error => {
                throw (error);
            });
    };
}
