import React, {PropTypes} from 'react';
import Tab from './TabListRow';
import TabRoomRow from './TabRoomRow';

const TabList = ({tabs, activeTabId, changeTab, deleteTab}) => {

    let tabChat = tabs.filter(tab => {
       return tab.id != 0;
    });
    console.log("active tab id on tab list: " + activeTabId);

    return (

        <ul className="nav nav-pills m-b-30">
            <TabRoomRow
                key = {0}
                tab={tabs[0]}
                changeTab={changeTab}
                active={activeTabId == 0}/>
            {tabChat.map(tab => {
                console.log(tab.id);
                return(
                    <Tab key={tab.id}
                         tab={tab}
                         active={activeTabId == tab.id}
                         changeTab={changeTab}
                         deleteTab={deleteTab}
                    />
                );
            })}

        </ul>

  );
};


export default TabList;
