//============================================================================
// 
// Author      : Li, Yuan
// File        : Client_List.java
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 1.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     Client List datamodel. This datamodel stores all clients list, which got 
// from backend database. The ListView widget of Main GUI use this datamodel to
// display these clients.
//
//============================================================================

package mandantGui;

import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;

/**
 * Client List datamodel
 * for all client list listview widget
 * @author abysmli
 */
public class Client_List {
    
    private final SimpleIntegerProperty clientid;
    private final SimpleStringProperty clientactive;
    
    public Client_List(int clientid, String clientactive) {
        this.clientid = new SimpleIntegerProperty(clientid);
        this.clientactive = new SimpleStringProperty(clientactive);
    }

    public int getClientid() {
        return this.clientid.get();
    }

    public void setClientid(int cliendid) {
        this.clientid.set(cliendid);
    }

    public String getClientactive() {
        return this.clientactive.get();
    }

    public void setClientactive(String clientactive) {
        this.clientactive.set(clientactive);
    }
}
