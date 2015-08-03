//============================================================================
// 
// Author      : Li, Yuan
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 1.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     Login GUI, at the beginning of programm the users must login to the System
// This GUI is the interface for user login behaviour. Two textfiled widgets are
// used to get the username and password. When "save_button" click event trigged
// , send the username and password to Main Class. The user certificate will be
// checked in Main class. If login successed, this GUI will be closed. If not, 
// the Error informations will be displayed in the panel.
//============================================================================

package mandantGui;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 * control the widgets actions. Control class for login class 
 * @author abysmli
 */
public class LoginController implements Initializable {

    // TextField widgets for getting username and password
    @FXML
    private TextField username_input;
    
    @FXML
    private PasswordField password_input;

    // Label widget to show error informations
    @FXML
    private Label information_label;

    // main class instance
    private MandantGUI application;

    /**
     * Initializes the controller class.
     * @param url not used
     * @param rb not used
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // clear the username inputfield and password inputfield
        username_input.setText("");
        password_input.setText("");
    }

    // get main class instance
    // @param application Main Class instance
    public void setApp(MandantGUI application) {
        this.application = application;
    }

    // trigged when user click "login" button
    // perform login action
    @FXML
    private void login_handler(ActionEvent event) {
        information_label.setText("");
        // if username is empty, show the error message
        if (username_input.getText().isEmpty()) {
            information_label.setText("Username is empty, please enter a Username!");
        // if password is empty, show the error message
        } else if (password_input.getText().isEmpty()) {
            information_label.setText("Password is empty, please enter a Password!");
        } else {
            // login action
            if (!application.mandantLogging(username_input.getText(), password_input.getText())) {
                // if login failed, show the message "username or password error"
                information_label.setText("Login failed, username or password error!");
                username_input.setText("");
                password_input.setText("");
            }
        }
    }

    // trigged when user pressed the key "Enter" in input_username field 
    @FXML
    private void username_enter(ActionEvent event) {
        // perform login action
        login_handler(event);
    }

    // trigged when user pressed the key "Enter" in input_password field 
    @FXML
    private void password_enter(ActionEvent event) {
        // perform login action
        login_handler(event);
    }

}
