import React, {PropTypes} from 'react';
import RoomListRow from './RoomListRow';

/**
 * function render a list of rooms
 * @param rooms
 * @returns {XML}
 * @constructor
 */
const RoomList = ({rooms, joinRoom}) => {
    return(
        <tbody>
            {rooms.map(room => <RoomListRow key={room.id} room={room} joinRoom={joinRoom}/>)}
        </tbody>
    );
};

RoomList.propTypes = {
    rooms: PropTypes.array.isRequired,
    joinRoom: PropTypes.func.isRequired
};

export default RoomList;
