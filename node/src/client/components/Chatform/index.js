import React from 'react';
import TopicContainer from '../../container/TopicContainer';

class ChatForm extends React.Component {

    submit(e) {
        e.preventDefault();
        let name = this.refs.name.value;
        let email = this.refs.email.value;
        let phone = this.refs.phone.value;
        let topicId = this.props.topic.selected;
        let message = this.refs.question.value;
        let topicName = this.props.topic.topics[topicId - 1].name;

        // Send first message and init welcome message
        this.props.sendMessageAndInitWelcome({message, name});
        this.props.sendRegister({name, email, phone, topicId, topicName, message});
    }

    render() {
        console.log('Data', this.props);
        return (
            <form className="chat-form d-flex flex-column" onSubmit={this.submit.bind(this)}>
                <div className="body">
                    <div className="content">

                        {this.props.inputRegisters.map((e, i) => {
                            return (
                                <div className="box-input" key={i}>
                                    <input className="" type="text" ref={e.toLowerCase().split(' ')[0]} placeholder={'Enter your ' + e}/>
                                    <div className="box"><i className={'icon-lio-' + e.toLowerCase()}/></div>
                                </div>
                            );
                        })}

                        <TopicContainer/>

                        <div className="area-question">
                            <textarea className="" type="text" ref="question" placeholder="TYPE YOUR QUESTION."
                                      rows="2"/>
                        </div>
                    </div>

                    <button className="btn btn-danger btn-form-send" type="submit">Send</button>
                </div>
            </form>
        );
    }
}

export default ChatForm;