import axios from 'axios';
import * as config from '../config/config';

// export function* getAllRooms () {
//     try{
//         return yield axios.get(config.GET_ALL_ROOMS);
//     }catch (err){
//         return null;
//     }
//
// }

class RoomApi {
    static getAllRooms(adminId) {
        return axios.get(`${config.GET_ALL_ROOMS}?id=1`);
    }

    static sendRequestJoinRoom(room) {
        return axios.get(`${config.SEND_REQUEST_JOIN_ROOM}`, room.id);
    }
}

export default RoomApi;
