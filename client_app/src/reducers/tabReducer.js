import * as types from '../actions/actionTypes';
import initialState from './initialState';

export default function tabReducer(state = initialState.tabs, action) {
    switch (action.type) {

        case types.CREATE_TAB:
            return [
                ...state,
                Object.assign(
                    {},
                    {
                        id: action.room.id,
                        title: action.room.customerName,
                        topic: action.room.topicName,
                        messages: []
                    }
                )
            ];

        case types.DELETE_TAB:
            return state.filter(tab => {
               return tab.id != action.tab.id;
            });

        //load messages from server
        case types.LOAD_MESSAGES_SUCCESS:
            return state.map( tab => {
                if (tab.id !== action.roomId) {

                    // This isn't the item we care about - keep it as-is
                    return tab;
                }

                console.log("room da load messages: " + action.roomId);
                console.log(action.messages);

                // Otherwise, this is the one we want - return an updated value
                return Object.assign(
                    {},
                    tab,
                    {messages: action.messages}
                );
            });

        case types.ADMIN_SEND_MESSAGE:
            return state.map( tab => {
                if (tab.id !== action.message.roomId) {

                    // This isn't the item we care about - keep it as-is
                    return tab;
                }

                // Otherwise, this is the one we want - return an updated value
                return Object.assign(
                    {},
                    tab,
                    {
                        messages: [
                            ...tab.messages,
                            action.message
                        ]
                    }
                );
            });

        case types.SERVER_SEND_MESSAGE:
            return state.map( tab => {
                if (tab.id !== action.roomId) {

                    // This isn't the item we care about - keep it as-is
                    return tab;
                }

                // Otherwise, this is the one we want - return an updated value
                return Object.assign(
                    {},
                    tab,
                    {
                        messages: [
                            ...tab.messages,
                            action.message
                        ]
                    }
                );
            });



        default:
            return state;
    }
}
