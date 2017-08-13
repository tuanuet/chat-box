import * as types from '../actions/actionTypes';
import initialState from './initialState';

export default function roomReducer(state = initialState.rooms, action) {
    switch (action.type) {

        // load rooms from server
        case types.LOAD_ROOMS_SUCCESS:
            return [
                ...state,
                ...action.rooms
            ];

        //when server confirm admin join room successfully
        case types.ADMIN_JOIN_ROOM_SUCCESS:
            return state.map(room => {
                if (room.id !== action.room.id) {
                    // This isn't the item we care about - keep it as-is
                    return room;
                }

                return Object.assign(
                    {},
                    room,
                    {status: 2}
                );
            });

        //when has new room
        case types.ADD_NEW_ROOM:
            return [
                action.room,
                ...state
            ];

        default:
            return state;

    }
}
