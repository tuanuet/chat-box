import React from 'react';

export default class Default extends React.Component {
    render() {
        let msg = this.props.msg;
        let metabox = msg.metadata ? <li className={msg.typeSender}><Metabox metadata={msg.metadata}/></li> : null;
        return (
            <div>
                <li className={msg.typeSender}>
                    <div className="msg">
                        <p className="msg-name">{msg.sender}</p>
                        <p>{msg.message.content}</p>
                    </div>
                </li>
                {metabox}
                <time>{msg.time}</time>
            </div>
        );


    }
}


function Metabox(props) {
    return (
        <div className="meta-box">
            <div className="font-weight-bold">{props.metadata.title}</div>
            <div>{props.metadata.description}</div>
            <img src={props.metadata.image}/>
        </div>
    );
}