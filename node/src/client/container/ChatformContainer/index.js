import React from 'react';
import {connect} from 'react-redux';
import Chatform from '../../components/Chatform';
import * as MessageTypes from '../../constants/MessageTypes';
import {addMessage} from '../../actions/action';
import {registerToken} from './actions';


class ChatformContainer extends React.Component {
    render() {
        return(<Chatform {...this.props}/>);
    }
}


function mapStateToProps(state) {
    return {
        topic: state.topic,
        room: state.room,
        inputRegisters: state.inputRegisters,
    };
}
function mapDispatchToProps(dispatch) {
    return{
        sendMessageAndInitWelcome : ({message,name}) => {
            let date = new Date().getHours() + ':' + new Date().getSeconds();

            dispatch(addMessage('self', name, {content: message}, date));
            dispatch(addMessage('other', '', {content: 'Stay stun in minutes', type: MessageTypes.NOTIFICATION}, ''));

        },
        sendRegister : (params) => {
            dispatch(registerToken(params));
        }
    };
    
}
export default connect(mapStateToProps,mapDispatchToProps)(ChatformContainer);