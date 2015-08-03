//============================================================================
// 
// Author      : Li, Yuan
// File        : Client_Permission.java
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 1.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     Client_Permission datamodel. This datamodel stores all client device relations
// , which got from backend database. The ListView widget of Main GUI use this 
// datamodel to display and control them.
//
//============================================================================

package mandantGui;

import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;

/**
 * client device datamodel
 * for client device ListView widget
 * @author Li, Yuan
 */
public class Client_Permission {

    private final SimpleIntegerProperty clientids;
    private final SimpleIntegerProperty clientidr;
    private final SimpleStringProperty permission;

    public Client_Permission(int clientids, int clientidr, String permission) {
        this.clientidr = new SimpleIntegerProperty(clientidr);
        this.clientids = new SimpleIntegerProperty(clientids);
        this.permission = new SimpleStringProperty(permission);
    }

    public int getClientidr() {
        return this.clientidr.get();
    }

    public void setClientidr(int cliendid) {
        this.clientidr.set(cliendid);
    }

    public int getClientids() {
        return this.clientids.get();
    }

    public void setClientids(int clientids) {
        this.clientids.set(clientids);
    }

    public String getPermission() {
        return this.permission.get();
    }

    public void setPermission(String permission) {
        this.permission.set(permission);
    }
}
