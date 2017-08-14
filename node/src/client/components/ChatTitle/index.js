import React from 'react';
import {connect} from 'react-redux';

class ChatTitle extends React.Component {

    constructor(props) {
        super(props);
        this.changeIcon = this.changeIcon.bind(this);
    }

    toggleChat() {
        $('.chat-body').slideToggle(this.changeIcon);
    }

    changeIcon() {
        this.arrowIcon.classList.toggle('fa-chevron-up');
        this.arrowIcon.classList.toggle('fa-chevron-down');
    }

    render() {
        return (
            <div className="chat-title" onClick={this.toggleChat.bind(this)}>
                <div className="icon"></div>
                <div className="title text-center">SUPPORT {this.props.customer.topicName ? this.props.customer.topicName : ''}</div>
                <div className="icon text-right"><i className="fa fa-chevron-down" ref={arrowIcon => this.arrowIcon = arrowIcon} /></div>
            </div>
        );
    }
}

function mapToProps(state) {
    return {
        customer: state.customer,
        room: state.room,
    };
}

export default connect(mapToProps)(ChatTitle);