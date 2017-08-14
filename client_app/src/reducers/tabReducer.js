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


                // Otherwise, this is the one we want - return an updated value
                return Object.assign(
                    {},
                    tab,
                    {messages: action.messages}
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

        case types.UPDATE_MESSAGE_META_LINK:
            return state.map( tab => {
                if (tab.id !== action.roomId) {

                    // This isn't the item we care about - keep it as-is
                    return tab;
                }

                // Otherwise, this is the one we want - return an updated value
                let currentTab = Object.assign({}, tab);
                let messages = currentTab.messages.map( message => {
                   if(message.id !== action.id) {
                       return message;
                   }

                   return Object.assign(
                       {},
                       message,
                       {metaLink: action.metaLink}
                   );
                });
                return Object.assign({}, tab, Object.assign({},currentTab, {messages: messages}));
            });


        default:
            return state;
    }
}
