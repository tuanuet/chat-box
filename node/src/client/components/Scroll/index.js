import React from 'react';
import ListMessage from '../ListMessage/index';
import {connect} from 'react-redux';

class Scroll extends React.Component {
    componentDidUpdate() {
        this.scroll();
    }
    componentDidMount(){
        this.scroll();
    }
    scroll() {
        let main = this.refs.main;
        if (main) {
            main.scrollTop = main.scrollHeight;
        }
    }

    render() {
        return (
            <div className="main" ref="main">
                <ListMessage messages={this.props.messages}/>
                <div style={{ float:'left', clear: 'both' }}
                     ref={(el) => { this.messagesEnd = el; }} >
                </div>
            </div>

        );
    }
}

function mapToProps(state) {
    return {
        messages: state.messages
    };
}

export default connect(mapToProps)(Scroll);
