import 'babel-polyfill';
import React from 'react';
import {render} from 'react-dom';
import configureStore from './store/configureStore';
import {Router, browserHistory} from 'react-router';  //clear URL
import routes from './route';  //route cua react
import {Provider} from 'react-redux';
import {loadRooms} from "./actions/roomActions";
import startConnection from './socket/chatSocket';
import {applyMiddleware} from 'redux';


const store = configureStore();

store.dispatch(loadRooms(1));
startConnection(store);


render(
    <Provider store={store}>
        <Router history={browserHistory} routes={routes} />
    </Provider>,
  document.getElementById('app')
);
