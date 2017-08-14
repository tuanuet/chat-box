import sequelize from '../config/sequelize.config';
import Sequelize from 'sequelize';


const Message = sequelize.define('messages', {
    id : {primaryKey: true, autoIncrement: true, type:Sequelize.INTEGER},
    room_id : {type:Sequelize.INTEGER},
    sender_id : {type:Sequelize.INTEGER},
    content : {type : Sequelize.STRING},
    message_type: {type : Sequelize.INTEGER}
},{
    timestamps : true,
    updatedAt: false,
    createdAt: 'created_at',
});


export default Message;