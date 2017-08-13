import React, {PropTypes} from 'react';
import RoomPage from './roompanel/RoomPage';

const RoomTabPanel = ({rooms, tabId, joinRoom}) => {
    return(
        <RoomPage
            key={tabId}
            rooms={rooms}
            joinRoom={joinRoom}
        />
    );
};

RoomTabPanel.propTypes = {
    rooms: PropTypes.array.isRequired,
    joinRoom: PropTypes.func.isRequired,
    tabId: PropTypes.number.isRequired
};

export default RoomTabPanel;
