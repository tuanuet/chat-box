import React, {PropTypes} from 'react';
import TabList from '../tab/TabList';
import MessageTabPanel from '../tabpanel/MessageTabPanel';
import RoomTabPanel from '../tabpanel/RoomTabPanel';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as tabActions from '../../actions/tabActions';
import * as roomActions from '../../actions/roomActions';
import * as messageActions from '../../actions/messageActions';
import * as Helper from '../../utils/manageRoomHelper';
import * as messageTypes from '../../config/messageTypes';


class ManageRoomPage extends React.Component {
    constructor(props, context) {
        super(props, context);

    this.state = {
        activeTabId: 0,
        message: ""
    };

    this.changeTab = this.changeTab.bind(this);
    this.deleteTab = this.deleteTab.bind(this);
    this.adminSendRequestJoinRoom = this.adminSendRequestJoinRoom.bind(this);
    this.handleMessageInput = this.handleMessageInput.bind(this);
    this.handleOnKeyUp = this.handleOnKeyUp.bind(this);
    this.handleFileUpload = this.handleFileUpload.bind(this);
  }

  componentWillReceiveProps(nextProps) {
        if(this.props.tabs.length < nextProps.tabs.length) {
            this.setState({
                activeTabId: nextProps.tabs[this.props.tabs.length].id
            });
        }
  }

  /**
   * event when click to change tab
   * @param tab
   */
    changeTab(event) {
        event.preventDefault();
        this.setState({
            activeTabId: event.target.value
        });
    }

    /**
     * event when click x button tab
     * @param event
     */
    deleteTab(event) {
        event.preventDefault();
        let selectedTab = Helper.getTabById(event.target.value, this.props.tabs);
        let indexOfTab = Helper.getIndexOfTabInArray(selectedTab, this.props.tabs);
        if(this.state.activeTabId == selectedTab.id) {
            if(indexOfTab == 0) {
                this.setState({
                    activeTabId: 0
                });
            } else {
                this.setState({
                    activeTabId: this.props.tabs[indexOfTab - 1].id
                });
            }
        }
        this.props.actions.deleteTab(selectedTab);
    }


    /**
     * event when click join room
     * @param event
     */
    adminSendRequestJoinRoom(event) {
        let roomId = event.target.value;
        let room = Helper.findRoomById(roomId, this.props.rooms);
        this.props.actions.adminSendRequestJoinRoom(room);
    }

    /**
     * update value of text area when enter a message
     * @param event
     */
    handleMessageInput(event) {
        let message = event.target.value;
        this.setState({
            message: message
        });
    }

    /**
     * send message
     * @param event
     */
    handleOnKeyUp(event) {
        let now = new Date();
        if(event.keyCode === 13) {
            let message = {
                message: {
                    content: this.state.message,
                    type: messageTypes.DEFAULT_MESSAGE
                },
                senderId: 0,
                name: "Admin",
                roomId: this.state.activeTabId,
                createdAt: now.toLocaleString()
            }
            this.props.actions.adminSendMessage(message);
            this.setState({
                message: ""
            })
        }
    }

    /**
     * handle file upload
     * @param event
     */
    handleFileUpload(event) {
        const data = new FormData();
        data.append('fileToUpload', event.target.files[0]);
        data.append('name', 'document file form user');
        // '/files' is your node.js route that triggers our middleware
        this.props.actions.adminUploadFile(data, this.state.activeTabId);
    }

    /**
     * get meta link of http message
     * @param message
     */
    getMetaLink(message, roomId) {
        if(message.message.content.includes('local.chat.com')) {
            return;
        }
        if(message.message.content.includes('http://') ||
            message.message.content.includes('https://')||
            message.message.content.includes('www.')) {
            this.props.actions.getMetaLink(message, roomId);
        }
    }

    /**
     *
     * @returns {XML}
     */
    render() {
        const {tabs} = this.props;
        const {rooms} = this.props;
        let listOfTabs = [{id: 0, title: "Room Chat"}, ...tabs];
        let tabPanel = null;
        console.log("1. now active tab: " + this.state.activeTabId);
        if (this.state.activeTabId == 0) {
            tabPanel = <RoomTabPanel tabId={0} rooms={rooms} joinRoom={this.adminSendRequestJoinRoom}/>;
        } else {
            console.log(tabs);
            console.log("2. now active tab: "   + this.state.activeTabId);
            let currentTab = Helper.getTabById(this.state.activeTabId, tabs);
            console.log(currentTab);
            tabPanel =
                <MessageTabPanel
                    tabId={currentTab.id}
                    topicName={currentTab.topic}
                    messages={currentTab.messages}
                    onChange={this.handleMessageInput}
                    messageInput={this.state.message}
                    onKeyUp={this.handleOnKeyUp}
                    fileUpload={this.handleFileUpload}
                    getMetaLink={this.getMetaLink.bind(this)}
                />;
        }

        return(
            <div>
                <TabList
                    tabs={listOfTabs}
                    activeTabId={this.state.activeTabId}
                    changeTab={this.changeTab}
                    deleteTab={this.deleteTab}
                />
                {tabPanel}
            </div>
        );
    }

}

/**
 * validation from props
 * @type {{activeTabId: *, actions: *}}
 */
ManageRoomPage.propTypes = {
    actions: PropTypes.object.isRequired,
    tabs: PropTypes.array.isRequired
};

/**
 * map active tab from  store
 * @param state
 * @param ownProps
 * @returns {{activeTabId: ({id, title, active}|*)}}
 */
function mapStateToProps(state, ownProps) {
    return {
        tabs: state.tabs,
        rooms: state.rooms
    };
}

function mapDispatchToProps(dispatch) {
    return {
        actions: bindActionCreators(Object.assign({}, messageActions, roomActions, tabActions), dispatch)
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(ManageRoomPage);
