import {combineReducers} from 'redux';
import courses from './courseReducer';
import authors from './authorReducer';
import ajaxCallInProgress from './ajaxStatusReducer';
import tabs from './tabReducer';
import rooms from './roomReducers';

const rootReducer = combineReducers({
    courses,
    authors,
    ajaxCallInProgress,
    tabs,
    rooms
});

export default rootReducer;
