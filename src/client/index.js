import React from 'react';
import ReactDom from 'react-dom';
import {Provider} from 'react-redux';

import store from './store/store';
import App from './container/App';
import {addTopic, hideForm, setRegisterForm, setRoomInfo} from './actions/action';
import {
    setCustomerInfo,
    setMessages,

} from './actions/action';

import registerForms from './source.json';
console.log(registerForms);

//set fields for form register
store.dispatch(setRegisterForm(registerForms.registers));
store.dispatch(addTopic(registerForms.topics));

if (sessionStorage.getItem('jwtToken')) {
    fetch(`http://local.chat.com/api/getData?token=${sessionStorage.getItem('jwtToken')}`, {
        method: 'get',
        mode: 'cors',
    }).then(res => res.json())
        .then(({customer, messages, admin, room}) => {

            //todo : handle admin object

            const {customerName, customerEmail, customerPhone, customerId} = customer;

            store.dispatch(setCustomerInfo(customerId,customerName, customerEmail, customerPhone));

            store.dispatch(setRoomInfo(room));

            store.dispatch(hideForm(true));

            const loadMessages = messages.map(message => {
                if (message.sender_id !== 0)
                    return {
                        typeSender : 'self',
                        sender : customerName,
                        message : { content: message.content, type : message.message_type},
                        time : message.created_at
                    }

                return {
                    typeSender : 'other',
                    sender : 'admin',
                    message : { content: message.content, type : message.message_type},
                    time : message.created_at
                };
            });

            store.dispatch(setMessages(loadMessages));

        })
        .catch(err => console.log(err));
}

/**
 * Create DOM with id chat-root
 * for rendering
 * @type {Element}
 */
const root = document.createElement('div');
root.setAttribute('id', 'chat-root');
document.body.appendChild(root);

ReactDom.render(
    <Provider store={store}>
        <App/>
    </Provider>,
    document.getElementById('chat-root')
);