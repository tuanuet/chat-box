import React from 'react';
import {connect} from 'react-redux';
import BottomBar from '../../components/BottomBar';
import {addMessage, setImage} from '../../actions/action';
import {getMetaLink, uploadImage} from './actions';


class BottomBarContainer extends React.Component {

    render() {
        return (
            <BottomBar {...this.props}/>
        );
    }
}

function mapStateToProps(state) {
    return {
        customer: state.customer,
        room: state.room,
        socket : state.socket,
        image : state.image,
    };
}
function mapDispatchToProps(dispatch) {
    return{
        dispatch,
        sendMessage : ({name,content}) => {
            let date = new Date().getHours() + ':' + new Date().getMinutes();
            dispatch(addMessage('self', name, {content}, date));
        },
        getMetaData : ({content}) => {
            let link = checkLink(content);
            if (link) {
                console.log('Link detected!');
                dispatch(getMetaLink(link, content));
            }
        },
        uploadImage : ({formData}) => {
            dispatch(uploadImage(formData));
            // dispatch(setImage({url : null}));
        }
    };
}

const checkLink = (content) => {
    let patt = /(([a-z]+:\/\/)?(([a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel|local|internal))(:[0-9]{1,5})?(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&amp;]*)?)?(#[a-zA-Z0-9!$&'()*+.=-_~:@/?]*)?)(\s+|$)/g;
    let result = patt.exec(content);
    if (result && result[0]) {
        return result[0];
    }
    return null;
};

export default connect(mapStateToProps,mapDispatchToProps)(BottomBarContainer);