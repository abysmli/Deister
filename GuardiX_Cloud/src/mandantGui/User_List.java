//============================================================================
// 
// Author      : Li, Yuan
// File        : User_List.java
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 1.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     User List datamodel. This datamodel stores all user list, which got 
// from backend database. The ListView widget of Main GUI use this datamodel to
// display these users.
//
//============================================================================

package mandantGui;

import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;

/**
 * User List datamodel
 * for all user list listview widget
 * @author abysmli
 */
public class User_List {
    
    private final SimpleIntegerProperty userid;
    private final SimpleStringProperty username;
    
    public User_List(int userid, String username) {
        this.userid = new SimpleIntegerProperty(userid);
        this.username = new SimpleStringProperty(username);
    }

    public int getUserid() {
        return this.userid.get();
    }

    public void setUserid(int cliendid) {
        this.userid.set(cliendid);
    }

    public String getUsername() {
        return this.username.get();
    }

    public void setUsername(String username) {
        this.username.set(username);
    }
}

