import React from 'react';
import ChatFormContainer from '../../container/ChatformContainer';
import ChatBoxContainer from '../../container/ChatboxContainer';
import ChatTitle from '../../components/ChatTitle';
import {connect} from 'react-redux';

require('../../css/cssGroup');

class App extends React.Component {

    render() {
        let child = this.props.hideForm ? <ChatBoxContainer/> : <ChatFormContainer/>;
        return (
            <div>
                <ChatTitle/>
                <div className="chat-body">
                    {child}
                </div>
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        hideForm: state.toggleForm,
    };
}

export default connect(mapStateToProps)(App);
