//============================================================================
// 
// Author      : Li, Yuan
// File        : Mandant_GUIContorller.java
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 2.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     the main GUI of Mandant GUI program. Get Mandant informations by sending
// post request to backend and display them in Mandant information Panel. Get 
// Client and Device Lists from backend. Get Client_Device relation from 
// backend.
// In this GUI allow people to edit the relation between the clients and 
// the devices which are belong to one Mandant. The Mandant can use this GUI for 
// adding, editing or deleting a relation record. PHP Backend get these
// requests and handle them by editing the client_device table in database. 
//
//============================================================================
package mandantGui;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.MenuButton;
import javafx.scene.control.MenuItem;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import javafx.scene.control.TableCell;
import javafx.scene.input.MouseEvent;
import javafx.scene.paint.Color;
import javafx.util.Callback;

/**
 * FXML Controller class Center Controller for Mandant GUI
 *
 * @author Li, Yuan
 */
public class Mandant_GUIController implements Initializable {

    // FXML TableView widget for display relation of clients
    @FXML
    private TableView<Client_Permission> client_permission_table;

    // FXML TableView widget for all user table
    @FXML
    private TableView<User_List> all_user_table;

    // FXML TableView widget for all clients table
    @FXML
    private TableView<Client_List> all_clients_table;

    // FXML TableColumn widget for columns of client_permission table
    @FXML
    private TableColumn<Client_Permission, String> col_client_s_id, col_client_r_id, col_permission;

    // FXML TableColumn widget for columns of all clients table
    @FXML
    private TableColumn<Client_List, String> all_client_id, all_client_active;

    // FXML TableColumn widget for columns of all user table
    @FXML
    private TableColumn<User_List, String> all_user_id, all_user_name;

    // FXML Label widget for displaying the information of mandant or Error informations
    @FXML
    private Label mandant_id_output, company_output, address_output, contact_output, createdate_output, record_method, information_label, username_label, client_id_label, user_edit_stat_label, group_label;

    // FXML MenuItem widget for read, fetch, delete menu button
    @FXML
    private MenuItem read_permission, fetch_permission, delete_permission;

    // FXML MenuButton widget
    @FXML
    private MenuButton permission_button;

    // FXML Button widget, clear button, save button
    @FXML
    private Button clear_button, save_button, client_activ_button, user_ok_button, add_user_button, edit_user_button, del_user_button, change_client_mac_button;

    // FXML TextField widget wigdet
    @FXML
    private TextField client_s_id_input, client_r_id_input, user_password_input, user_name_input, client_mac_field;

    // ObersvaleList to store the datamodel of all client table, client device table
    private final ObservableList<Client_Permission> client_permission_data = FXCollections.observableArrayList();
    private final ObservableList<User_List> all_users_data = FXCollections.observableArrayList();
    private final ObservableList<Client_List> all_clients_data = FXCollections.observableArrayList();

    // to determine whether "add record" mode or "edit record" mode is used. 
    private boolean AddRecordFlag = true;

    // the index of client device records 
    private int iRecordIndex;
    // the index of client records 
    private int iRecordClientIndex;
    // the index of user records 
    private int iRecordUserIndex;

    // Main Class instance
    private MandantGUI application;

    // http instance from class HttpRequestHandler, to realize the communication between Java GUI and PHP backend.
    private HttpRequestHandler http;

    /**
     * Initializes the controller class. get mandant information by sending post
     * request to backend get all client list by sending post request to
     * backend.
     *
     * @param application application instance of class Mandant_GUI
     * @param http httpRequsetHandler instance for sending HTTP requests
     */
    public void startApp(MandantGUI application, HttpRequestHandler http) {
        this.http = http;
        this.application = application;
        try {
            // get mandant informations and display them
            showMandantInformation();
            // get user list and display them and store all json data in all_user_data datamodel
            getUser();
            // get client list and display them and store all json data in all_clients_data datamodel
            getClientList();
            // get client permission list and display them and store all json data in client_permission_data datamodel
            getClientPermission();
        } catch (Exception e) {
            System.out.println("Error Ocurred in MandantGUI! Details: " + e.getMessage() + e.toString());
        }
    }

    /**
     * Initializes the controller class.
     *
     * @param url
     * @param rb
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // client sender id input item set to empty
        client_s_id_input.setText("");
        // client receiver id input item set to empty
        client_r_id_input.setText("");
        // permission button set to empty
        permission_button.setText("read");
        record_method.setText("Add Record:");
        AddRecordFlag = true;
    }

    // get mandant informations and display them
    private void showMandantInformation() throws Exception {
        // get mandant information json data by sending post request to backend
        JSONObject MandantInformation = http.getMandantInformation();
        // display all informations in panel
        // display mandant id
        mandant_id_output.setText(MandantInformation.get("mandant_id").toString());
        // display mandant firman name
        company_output.setText(MandantInformation.get("mandant_firmname").toString());
        // display mandant address
        address_output.setText(MandantInformation.get("mandant_address").toString());
        // display mandant contact
        contact_output.setText(MandantInformation.get("mandant_contact").toString());
        // display mandant create date
        createdate_output.setText(MandantInformation.get("date_insert").toString());
        // display username
        username_label.setText(MandantInformation.get("username").toString());
        // display group
        if (MandantInformation.get("user_id").toString().equals("1")) {
            group_label.setText("Admins");
        } else {
            group_label.setText("Users");
        }
    }

    // get all user and display them
    private void getUser() throws Exception {
        // get user list jsondata by sending post request to backend
        JSONArray UserList = http.getUserList();
        // set all user table disabled
        all_user_table.setEditable(false);
        // set a callback function in order to get user click event
        // this function link to a table cell and the value of this cell must be integer
        Callback<TableColumn<User_List, String>, TableCell<User_List, String>> integerCellFactory
                = new Callback<TableColumn<User_List, String>, TableCell<User_List, String>>() {
                    @Override
                    public TableCell<User_List, Integer> call(TableColumn p) {
                        UserIntegerTableCell cell = new UserIntegerTableCell();
                        // get mouse click event
                        cell.addEventFilter(MouseEvent.MOUSE_CLICKED, new UserEventHandler());
                        return cell;
                    }
                };
        // set a callback function in order to get user click event
        // this function link to a table cell and the value of this cell must be string
        Callback<TableColumn<User_List, String>, TableCell<User_List, String>> stringCellFactory
                = new Callback<TableColumn<User_List, String>, TableCell<User_List, String>>() {
                    @Override
                    public TableCell<User_List, String> call(TableColumn p) {
                        UserStringTableCell cell = new UserStringTableCell();
                        // get mouse click event
                        cell.addEventFilter(MouseEvent.MOUSE_CLICKED, new UserEventHandler());
                        return cell;
                    }
                };
        // convert jsondata to datamodel
        // link table column to datamodel
        all_user_id.setCellValueFactory(new PropertyValueFactory<User_List, String>("userid"));
        // link table cell to event handler
        all_user_id.setCellFactory(integerCellFactory);
        // link table column to datamodel
        all_user_name.setCellValueFactory(new PropertyValueFactory<User_List, String>("username"));
        // link table cell to event handler
        all_user_name.setCellFactory(stringCellFactory);
        // link table to datamodel
        all_user_table.setItems(all_users_data);
        //client_user_table.getColumns().addAll(col_user_id, col_user_login, col_client_id, col_client_login, col_permission);
        // convert jsondata to datamodel
        for (int i = 0; i < UserList.size(); i++) {
            JSONObject obj = (JSONObject) UserList.get(i);
            // link table to datamodel
            all_users_data.add(new User_List(Integer.parseInt(obj.get("user_id").toString()), obj.get("username").toString()));
        }
    }

    // get values from table cell
    // this function will be called, when mouse click event triggered
    // update the cell and return the string value of this cell
    class UserIntegerTableCell extends TableCell<User_List, Integer> {

        // update the cell 
        @Override
        public void updateItem(Integer item, boolean empty) {
            super.updateItem(item, empty);
            setText(empty ? null : getString());
            setGraphic(null);
        }

        // get the value of cell
        private String getString() {
            return getItem() == null ? "" : getItem().toString();
        }
    }

    // get values from table cell
    // this function will be called, when mouse click event triggered
    // update the cell and return the string value of this cell
    class UserStringTableCell extends TableCell<User_List, String> {

        // update the cell 
        @Override
        public void updateItem(String item, boolean empty) {
            super.updateItem(item, empty);
            setText(empty ? null : getString());
            setGraphic(null);
        }

        // get the value of cell
        private String getString() {
            return getItem() == null ? "" : getItem().toString();
        }
    }

    // Class UserEventHandler realize the interface EventHandler
    // Methode handle is used for handle mouse click event
    // get the value of the cell which user clicked, and set 
    // value to client id input item
    class UserEventHandler implements EventHandler<MouseEvent> {

        @Override
        public void handle(MouseEvent t) {
            TableCell<User_List, String> c = (TableCell<User_List, String>) t.getSource();
            // get value of cell from datamodel
            iRecordUserIndex = c.getIndex();
            if (iRecordUserIndex < all_users_data.size()) {
                // set the value to user name input item
                user_name_input.setText(all_users_data.get(iRecordUserIndex).getUsername());
                // set the value to to user edit label item
                user_edit_stat_label.setText("Edit User");
            }
        }
    }

    // get all client list and display them
    private void getClientList() throws Exception {
        // get client list jsondata by sending post request to backend
        JSONArray ClientList = http.getClientList();
        // set all client table disabled
        all_clients_table.setEditable(false);
        // set a callback function in order to get user click event
        // this function link to a table cell and the value of this cell must be integer
        Callback<TableColumn<Client_List, String>, TableCell<Client_List, String>> integerCellFactory
                = new Callback<TableColumn<Client_List, String>, TableCell<Client_List, String>>() {
                    @Override
                    public TableCell<Client_List, Integer> call(TableColumn p) {
                        ClientIntegerTableCell cell = new ClientIntegerTableCell();
                        // get mouse click event
                        cell.addEventFilter(MouseEvent.MOUSE_CLICKED, new ClientEventHandler());
                        return cell;
                    }
                };
        // set a callback function in order to get user click event
        // this function link to a table cell and the value of this cell must be string
        Callback<TableColumn<Client_List, String>, TableCell<Client_List, String>> stringCellFactory
                = new Callback<TableColumn<Client_List, String>, TableCell<Client_List, String>>() {
                    @Override
                    public TableCell<Client_List, String> call(TableColumn p) {
                        ClientStringTableCell cell = new ClientStringTableCell();
                        // get mouse click event
                        cell.addEventFilter(MouseEvent.MOUSE_CLICKED, new ClientEventHandler());
                        return cell;
                    }
                };
        // convert jsondata to datamodel
        // link table column to datamodel
        all_client_id.setCellValueFactory(new PropertyValueFactory<Client_List, String>("clientid"));
        // link table cell to event handler
        all_client_id.setCellFactory(integerCellFactory);
        // link table column to datamodel
        all_client_active.setCellValueFactory(new PropertyValueFactory<Client_List, String>("clientactive"));
        // link table cell to event handler
        all_client_active.setCellFactory(stringCellFactory);
        // link table to datamodel
        all_clients_table.setItems(all_clients_data);
        // convert jsondata to datamodel
        for (int i = 0; i < ClientList.size(); i++) {
            JSONObject obj = (JSONObject) ClientList.get(i);
            String sActive;
            // check wether client is active
            if (obj.get("client_active").toString().equals("1")) {
                sActive = "Active";
            } else {
                sActive = "Inactive";
            }
            // link table to datamodel
            all_clients_data.add(new Client_List(Integer.parseInt(obj.get("client_id").toString()), sActive));
        }
    }

    // get values from table cell
    // this function will be called, when mouse click event triggered
    // update the cell and return the string value of this cell
    class ClientIntegerTableCell extends TableCell<Client_List, Integer> {

        // update the cell 
        @Override
        public void updateItem(Integer item, boolean empty) {
            super.updateItem(item, empty);
            setText(empty ? null : getString());
            setGraphic(null);
        }

        // get the value of cell
        private String getString() {
            return getItem() == null ? "" : getItem().toString();
        }
    }

    // get values from table cell
    // this function will be called, when mouse click event triggered
    // update the cell and return the string value of this cell
    class ClientStringTableCell extends TableCell<Client_List, String> {

        // update the cell 
        @Override
        public void updateItem(String item, boolean empty) {
            super.updateItem(item, empty);
            setText(empty ? null : getString());
            setGraphic(null);
        }

        // get the value of cell
        private String getString() {
            return getItem() == null ? "" : getItem().toString();
        }
    }

    // Class ClientEventHandler realize the interface EventHandler
    // Methode handle is used for handle mouse click event
    // get the value of the cell which user clicked, and set 
    // value to client id input item
    class ClientEventHandler implements EventHandler<MouseEvent> {

        @Override
        public void handle(MouseEvent t) {
            TableCell<Client_List, String> c = (TableCell<Client_List, String>) t.getSource();
            // get value of cell from datamodel
            iRecordClientIndex = c.getIndex();
            if (iRecordClientIndex < all_clients_data.size()) {
                if(client_s_id_input.getText().equals("")) {
                    // set the value to client id input item
                    client_s_id_input.setText(Integer.toString(all_clients_data.get(iRecordClientIndex).getClientid()));                    
                } else {
                    client_r_id_input.setText(Integer.toString(all_clients_data.get(iRecordClientIndex).getClientid()));
                }
                // set the value to to client id label item
                client_id_label.setText(Integer.toString(all_clients_data.get(iRecordClientIndex).getClientid()));
                // set Button caption
                String stat;
                if (all_clients_data.get(iRecordClientIndex).getClientactive().equals("Active")) {
                    stat = "Deactivate";
                } else {
                    stat = "Activate";
                }
                client_activ_button.setText(stat);
            }
        }
    }

    // get client permission list and display them with control
    private void getClientPermission() throws Exception {
        // get client permission list jsondata by sending post request to backend
        JSONArray JClient_Permission = http.getClientPermission();
        // set client permission table disabled
        client_permission_table.setEditable(false);
        // set a callback function in order to get user click event
        // this function link to a table cell and the value of this cell must be integer
        Callback<TableColumn<Client_Permission, String>, TableCell<Client_Permission, String>> integerCellFactory
                = new Callback<TableColumn<Client_Permission, String>, TableCell<Client_Permission, String>>() {
                    @Override
                    public TableCell<Client_Permission, Integer> call(TableColumn p) {
                        ClientPermissionIntegerTableCell cell = new ClientPermissionIntegerTableCell();
                        // get mouse click event
                        cell.addEventFilter(MouseEvent.MOUSE_CLICKED, new ClientPermissionEventHandler());
                        return cell;
                    }
                };
        // set a callback function in order to get user click event
        // this function link to a table cell and the value of this cell must be string
        Callback<TableColumn<Client_Permission, String>, TableCell<Client_Permission, String>> stringCellFactory
                = new Callback<TableColumn<Client_Permission, String>, TableCell<Client_Permission, String>>() {
                    @Override
                    public TableCell<Client_Permission, String> call(TableColumn p) {
                        ClientPermissionStringTableCell cell = new ClientPermissionStringTableCell();
                        // get mouse click event
                        cell.addEventFilter(MouseEvent.MOUSE_CLICKED, new ClientPermissionEventHandler());
                        return cell;
                    }
                };
        // link table column to datamodel
        col_client_s_id.setCellValueFactory(new PropertyValueFactory<Client_Permission, String>("clientids"));
        // link table cell to event handler
        col_client_s_id.setCellFactory(integerCellFactory);
        // link table column to datamodel
        col_client_r_id.setCellValueFactory(new PropertyValueFactory<Client_Permission, String>("clientidr"));
        // link table cell to event handler
        col_client_r_id.setCellFactory(integerCellFactory);
        // link table column to datamodel
        col_permission.setCellValueFactory(new PropertyValueFactory<Client_Permission, String>("permission"));
        // link table cell to event handler
        col_permission.setCellFactory(stringCellFactory);
        client_permission_table.setItems(client_permission_data);
        // convert jsondata to datamodel
        for (int i = 0; i < JClient_Permission.size(); i++) {
            JSONObject obj = (JSONObject) JClient_Permission.get(i);
            // link table to datamodel
            client_permission_data.add(new Client_Permission(Integer.parseInt(obj.get("client_id_s").toString()), Integer.parseInt(obj.get("client_id_r").toString()), obj.get("permission").toString()));
        }
    }

    // get values from table cell
    // this function will be called, when mouse click event triggered
    // update the cell and return the string value of this cell
    class ClientPermissionIntegerTableCell extends TableCell<Client_Permission, Integer> {

        // update the cell 
        @Override
        public void updateItem(Integer item, boolean empty) {
            super.updateItem(item, empty);
            setText(empty ? null : getString());
            setGraphic(null);
        }

        // get the value of cell
        private String getString() {
            return getItem() == null ? "" : getItem().toString();
        }
    }

    // get values from table cell
    // this function will be called, when mouse click event triggered
    // update the cell and return the string value of this cell
    class ClientPermissionStringTableCell extends TableCell<Client_Permission, String> {

        // update the cell 
        @Override
        public void updateItem(String item, boolean empty) {
            super.updateItem(item, empty);
            setText(empty ? null : getString());
            setGraphic(null);
        }

        // get the value of cell
        private String getString() {
            return getItem() == null ? "" : getItem().toString();
        }
    }

    // Class ClientPermissionEventHandler realize the interface EventHandler
    // Methode handle is used for handle mouse click event
    // get the value of the cell which user clicked, and set 
    // value to client sender id input item and client receiver id input item
    // and permission button
    class ClientPermissionEventHandler implements EventHandler<MouseEvent> {

        @Override
        public void handle(MouseEvent t) {
            TableCell<Client_Permission, Integer> c = (TableCell<Client_Permission, Integer>) t.getSource();
            // get value of cell from datamodel
            iRecordIndex = c.getIndex();
            if (iRecordIndex < client_permission_data.size()) {
                // set the value to client id input item
                client_s_id_input.setText(Integer.toString(client_permission_data.get(iRecordIndex).getClientids()));
                // set the value to client id input item
                client_r_id_input.setText(Integer.toString(client_permission_data.get(iRecordIndex).getClientidr()));
                // set the value to permission button
                permission_button.setText(client_permission_data.get(iRecordIndex).getPermission());
                // change methode label to "Edit Record"
                record_method.setText("Edit Record:");
                AddRecordFlag = false;
            }
        }
    }

    // update the information label 
    // information label is used for displaying the error or success informations
    private void setRecordInformationLabel(String sInformation, String sColor) {
        // set up the color of this information label
        information_label.setTextFill(Color.web(sColor));
        // set the text of this information label
        information_label.setText(sInformation);
    }

    // event when user select permission read
    @FXML
    private void setPermissionRead(ActionEvent event) {
        // set up the text of permission button
        permission_button.setText("read");
    }

    // event when user select permission fetch
    @FXML
    private void setPermissionFetch(ActionEvent event) {
        // set up the text of permission button
        permission_button.setText("fetch");
    }

    // event when user select permission delete
    @FXML
    private void setPermissionDelete(ActionEvent event) {
        // set up the text of permission button
        permission_button.setText("delete");
    }

    // reset all value of input field
    @FXML
    private void InputFieldReset(ActionEvent event) {
        // client sender id input item set to empty
        client_s_id_input.setText("");
        // client receiver id input item set to empty
        client_r_id_input.setText("");
        // permission button set to empty
        permission_button.setText("read");
        // information label set to empty
        setRecordInformationLabel("", "black");
    }

    // user press enter in device_id_input field
    @FXML
    private void device_enter(ActionEvent event) {
        InputFieldSave(event);
    }

    // user press enter in client_id_input field
    @FXML
    private void client_enter(ActionEvent event) {
        InputFieldSave(event);
    }

    // Event Handler when user click save button
    // control center for sending post requst which
    // used for adding new record, deleting a record 
    // or editing a record
    @FXML
    private void InputFieldSave(ActionEvent event) {
        // reset information label
        setRecordInformationLabel("", "black");
        if (client_s_id_input.getText().equals("") || client_r_id_input.getText().equals("")) {
            setRecordInformationLabel("Client ID or Device ID can not be NULL!", "red");
            return;
        }
        // get device id from device id input item
        int iClientIDS = Integer.parseInt(client_s_id_input.getText());
        // get client id from client id input item
        int iClientIDR = Integer.parseInt(client_r_id_input.getText());

        // if AddRecordFlag setted
        // that means input field now in add record mode
        if (AddRecordFlag) {
            String sMessage = new String();
            try {
                // send post request to backend in order to add a new record in database
                sMessage = http.addClientPermission(Integer.toString(iClientIDS), Integer.toString(iClientIDR), permission_button.getText());
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
            // post successed
            if ("Success".equals(sMessage)) {
                // add the new record to datamodel and display them
                setRecordInformationLabel("Sending Post Request...", "blue");
                client_permission_data.add(new Client_Permission(
                        iClientIDS,
                        iClientIDR,
                        permission_button.getText()
                ));
                // reset input field items
                InputFieldReset(event);
                setRecordInformationLabel("Added record successfully!", "green");
            } else {
                setRecordInformationLabel("Added record Failed! Details: " + sMessage, "red");
            }
            // if AddRecordFlag unsetted
            // that means input field now in edit record mode
        } else {
            String sMessage = new String();
            try {
                // send post request to backend in order to edit a record in database
                sMessage = http.editClientPermission(Integer.toString(client_permission_data.get(iRecordIndex).getClientids()), Integer.toString(client_permission_data.get(iRecordIndex).getClientidr()), client_permission_data.get(iRecordIndex).getPermission(), Integer.toString(iClientIDS), Integer.toString(iClientIDR), permission_button.getText());
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
            // post successed
            if ("Success".equals(sMessage)) {
                setRecordInformationLabel("Sending Post Request...", "blue");
                // refresh List View in order to display the new edited record
                client_permission_data.get(iRecordIndex).setClientids(iClientIDS);
                client_permission_data.get(iRecordIndex).setClientidr(iClientIDR);
                client_permission_data.get(iRecordIndex).setPermission(permission_button.getText());
                // refresh TableView in order to display the new value in TableView
                client_permission_table.getColumns().get(0).setVisible(false);
                client_permission_table.getColumns().get(0).setVisible(true);
                // reset input field items
                InputFieldReset(event);
                setRecordInformationLabel("Edit record successfully!", "green");
            } else {
                setRecordInformationLabel("Edit record Failed! Details: " + sMessage, "red");
            }
        }
    }

    // event, when user click add record button
    @FXML
    private void add_record(ActionEvent event) {
        // reset input field
        InputFieldReset(event);
        // change methode label to "Add Record"
        record_method.setText("Add Record:");
        AddRecordFlag = true;
    }

    // event, when user click edit record button
    @FXML
    private void edit_record(ActionEvent event) {
        // reset input field
        InputFieldReset(event);
        // change methode label to "Edit Record"
        record_method.setText("Edit Record:");
        AddRecordFlag = false;
    }

    // event, when user click delete record button
    @FXML
    private void delete_record(ActionEvent event) {
        // check whether the client sender id input item or client receiver id input item are empty
        if (client_s_id_input.getText().isEmpty() || client_r_id_input.getText().isEmpty()) {
            setRecordInformationLabel("Error! Client ID or Device ID is empty. Can not delete. ", "red");
        } else {
            String sMessage = new String();
            try {
                // send post request to backend in order to delete a record in database
                sMessage = http.delClientPermission(Integer.toString(client_permission_data.get(iRecordIndex).getClientids()), Integer.toString(client_permission_data.get(iRecordIndex).getClientidr()), client_permission_data.get(iRecordIndex).getPermission());
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
            // post successed
            if ("Success".equals(sMessage)) {
                setRecordInformationLabel("Sending Post Request...", "blue");
                // remove the corresponding record in database
                client_permission_data.remove(iRecordIndex);
                InputFieldReset(event);
                setRecordInformationLabel("Delete record successfully!", "green");
            } else {
                setRecordInformationLabel("Delete record Failed! Details: " + sMessage, "red");
            }
        }
    }

    // activate client or deactivate client
    @FXML
    private void client_activ(ActionEvent event) {
        // check whether in deactivate mode or in activate mode
        if (client_activ_button.getText().equals("Deactivate")) {
            try {
                // send post request to backende
                // when successed
                if ("Success".equals(http.deactClient(client_id_label.getText()))) {
                    // show successed message
                    setRecordInformationLabel("Deactivate Client Successfully!", "green");
                    // change the text of client activ button
                    client_activ_button.setText("Activate");
                    // update table
                    all_clients_data.get(iRecordClientIndex).setClientactive("Inactive");
                } else {
                    // show failed message
                    setRecordInformationLabel("Deactivate Client Failed!", "red");
                }
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
        } else {
            try {
                // send post request to backende
                // when successed
                if ("Success".equals(http.actClient(client_id_label.getText()))) {
                    // show successed message
                    setRecordInformationLabel("Activate Client Successfully!", "green");
                    // change the text of client activ button
                    client_activ_button.setText("Deactivate");
                    // update table
                    all_clients_data.get(iRecordClientIndex).setClientactive("Active");
                } else {
                    // show failed message
                    setRecordInformationLabel("Activate Client Failed!", "red");
                }
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
        }
        // refresh TableView in order to display the new value in TableView
        all_clients_table.getColumns().get(0).setVisible(false);
        all_clients_table.getColumns().get(0).setVisible(true);
    }

    // change the mac of a client
    @FXML
    private void change_client_mac(ActionEvent event) {
        try {
            if ("Success".equals(http.changeClientMAC(Integer.toString(all_clients_data.get(iRecordClientIndex).getClientid()), client_mac_field.getText()))) {
                setRecordInformationLabel("Client MAC changed Successfully!", "green");
            } else {
                setRecordInformationLabel("Client MAC changed Failed!", "red");
            }
        } catch (Exception e) {
            // connect to backend error
            System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
        }
    }

    // change the mac of a client, when user enter pressed
    @FXML
    private void client_mac_filed_enter(ActionEvent event) {
        // redirect to change_client_mac event handler
        change_client_mac(event);
    }

    // user press enter key in username field
    @FXML
    private void username_enter(ActionEvent event) {
        // user click confirm button action
        user_confirm(event);
    }

    // user press enter key in password field
    @FXML
    private void user_password_enter(ActionEvent event) {
        // user click confirm button action
        user_confirm(event);
    }

    // user click confirm button action
    @FXML
    private void user_confirm(ActionEvent event) {
        // get username and password from TextField widgets
        String sUsername = user_name_input.getText();
        String sPassword = user_password_input.getText();
        // check whether there TextField are blank or not
        if (sUsername.equals("") || sPassword.equals("")) {
            // show error message
            setRecordInformationLabel("Username or password can not be blank!", "red");
            return;
        }
        // check which mode now used
        if (user_edit_stat_label.getText().equals("Add User")) {
            try {
                // send post request to backend to add this use
                // the result will be stored in variable "sResult"
                String sResult = http.addUser(sUsername, sPassword);
                // when successed
                if (sResult.substring(0, 7).equals("Success")) {
                    // show successed message
                    setRecordInformationLabel("Add User Successfully!", "green");
                    // reset the input fields
                    user_name_input.setText("");
                    user_password_input.setText("");
                    // add this user into gui table
                    all_users_data.add(new User_List(Integer.parseInt(sResult.substring(7)), sUsername));
                } else {
                    // show failed message
                    setRecordInformationLabel(sResult, "red");
                }
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
        } else if (user_edit_stat_label.getText().equals("Edit User")) {
            try {
                // send post request to backend to add this use
                // the result will be stored in variable "sResult"                
                String sResult = http.editUser(Integer.toString(all_users_data.get(iRecordUserIndex).getUserid()), sUsername, sPassword);
                // when successed                
                if (sResult.equals("Success")) {
                    // refresh gui table
                    all_users_data.get(iRecordUserIndex).setUsername(sUsername);
                    // show successed message
                    setRecordInformationLabel("Edit User Successfully!", "green");
                    // reset the input fields                    
                    user_name_input.setText("");
                    user_password_input.setText("");
                    // refresh TableView in order to display the new value in TableView
                    all_user_table.getColumns().get(0).setVisible(false);
                    all_user_table.getColumns().get(0).setVisible(true);
                } else {
                    // show error message
                    setRecordInformationLabel(sResult, "red");
                }
            } catch (Exception e) {
                // connect to backend error
                System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            }
        }
    }

    // edit user button action
    @FXML
    private void edit_user(ActionEvent event) {
        // reset all input fields
        setRecordInformationLabel("", "black");
        user_name_input.setText("");
        user_password_input.setText("");
        user_edit_stat_label.setText("Edit User");
    }

    // add user button action
    @FXML
    private void add_user(ActionEvent event) {
        // reset all input fields
        setRecordInformationLabel("", "black");
        user_name_input.setText("");
        user_password_input.setText("");
        user_edit_stat_label.setText("Add User");
    }

    // delete user button action
    @FXML
    private void delete_user(ActionEvent event) {
        try {
            // send user id to backend in order to deactivate this user
            String sResult = http.delUser(Integer.toString(all_users_data.get(iRecordUserIndex).getUserid()));
            // deactivate successed
            if (sResult.equals("Success")) {
                // show successed message
                setRecordInformationLabel("Delete User Successfully!", "green");
                // reset all input fields
                user_name_input.setText("");
                user_password_input.setText("");
                // delete this user from gui table
                all_users_data.remove(iRecordUserIndex);
            } else {
                // show error message
                setRecordInformationLabel(sResult, "red");
            }
        } catch (Exception e) {
            // connect to backend error
            System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
        }
    }

    // logout action
    @FXML
    private void logout(ActionEvent event) {
        application.logout();
    }
}
