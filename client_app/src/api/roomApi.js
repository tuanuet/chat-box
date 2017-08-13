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
        return axios.get(`${config.HOST}${config.GET_ALL_ROOMS}?id=1`);
    }
}

export default RoomApi;
