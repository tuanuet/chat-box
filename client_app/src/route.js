import React from 'react';
import { Route, IndexRoute } from 'react-router';
import App from './components/App';
import CoursesPage from './components/course/CoursesPage';
import ManageRoomPage from './components/room/ManageRoomPage';

export default (
  <Route path="/room" component={App}>
    <IndexRoute component={ManageRoomPage}/>
    <Route path="courses" component={CoursesPage}/>
  </Route>
);
