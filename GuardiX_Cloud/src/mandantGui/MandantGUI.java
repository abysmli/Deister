//============================================================================
// 
// Author      : Li, Yuan
// File        : MandantGUI.java
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 2.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     Web Graphical User Interface of Mandant Controller Main routine. 
// Link login GUI and Mandant GUI. Control the whole program progress.
//
//============================================================================

package mandantGui;

import java.io.InputStream;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.fxml.JavaFXBuilderFactory;
import javafx.scene.Scene;
import javafx.scene.image.Image;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import javafx.stage.StageStyle;

/**
 * Main Class MandantGUI
 * Web Graphical User Interface of Mandant Controller Main routine. 
 * Link login GUI and Mandant GUI. Control the whole program progress.
 * @author abysmli
 */
public class MandantGUI extends Application {

    // config file name
    private final String sConfigFilename="config.ini";
    // Config class instance for getting config parameters
    private CConfig config;
    // store backend url
    private String sURL;
    // window stage
    private Stage stage;
    // HttpRequestHandler instance for sending http requests
    public HttpRequestHandler http;
    // Start MandantGUI
    // @param primaryStage main stage of application
    @Override
    public void start(Stage primaryStage) throws Exception {
        try {
            // Config class instance for getting config parameters
            config = new CConfig(sConfigFilename);
            // get URL from config file
            sURL=config.getURL();
            // HttpRequestHandler instance for sending http requests
            http = new HttpRequestHandler(sURL);
            // setup Stage style
            primaryStage.initStyle(StageStyle.UTILITY);
            stage = primaryStage;
            // set title of stage
            stage.setTitle("Mandant GUI");
            // set application icon
            stage.getIcons().add(new Image("/images/icon.png"));
            // disable resize properties of window
            stage.setResizable(false);
            // open login gui
            gotoLogin();
            // show stage
            primaryStage.show();
        } catch (Exception ex) {
            // error log when errors occurred
            Logger.getLogger(MandantGUI.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    // reset HttpRequestHandler instance
    // release all session informations and cookies
    // prepare for next authentication
    public void logout() {
        http = null;
        http = new HttpRequestHandler(sURL);
        // open login gui
        gotoLogin();
    }

    // login by sending post request which include the use certificates
    // when login successed, open the mandant GUI
    // @return boolean successed return true, failed return error
    // @param mandant_username username of mandant for login action
    // @param password password for login
    public boolean mandantLogging(String mandant_username, String password) {
        try {
            if (http.MandantLogin(mandant_username, password)) {
                // login successful, and open mandant GUI
                gotoMainGUI();
                return true;
            } else {
                return false;
            }
        } catch (Exception e) {
            // error log when errors occurred
            System.out.println("Error Ocurred! Details: " + e.getMessage() + e.toString());
            return false;
        }
    }

    // replace the content of scence in order to open the mandant GUI
    private void gotoMainGUI() {
        try {
            // replace the content of scence with "Mandant_GUI.fxml", so that open main GUI
            Mandant_GUIController maingui = (Mandant_GUIController) replaceSceneContent("Mandant_GUI.fxml");
            // MandantGUI instance and http instance will be passed to Mandant_GUIController instance
            maingui.startApp(this, http);
        } catch (Exception ex) {
            // error log when errors occurred
            Logger.getLogger(MandantGUI.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    // replace the content of scence in order to open the login GUI
    private void gotoLogin() {
        try {
            // replace the content of scence with "Login.fxml", so that open login GUI
            LoginController login = (LoginController) replaceSceneContent("Login.fxml");
            // transfer MandantGUI instance to LoginController login instance
            login.setApp(this);
        } catch (Exception ex) {
            // error log when errors occurred
            Logger.getLogger(MandantGUI.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    // used to replace content of scence
    // and in this way realized the change of GUIs
    // @param fxml scene fxml file for opening
    // @return initializable return ein instance
    private Initializable replaceSceneContent(String fxml) throws Exception {
        // FXMLLoader for loading GUI fxml files
        FXMLLoader loader = new FXMLLoader();
        InputStream in = MandantGUI.class.getResourceAsStream(fxml);
        loader.setBuilderFactory(new JavaFXBuilderFactory());
        loader.setLocation(MandantGUI.class.getResource(fxml));
        AnchorPane page;
        try {
            // load AnchorPane
            page = (AnchorPane) loader.load(in);
        } finally {
            in.close();
        }
        // create new scene
        Scene scene = new Scene(page);
        stage.setScene(scene);
        // resize scene
        stage.sizeToScene();
        return (Initializable) loader.getController();
    }

    /**
     * The main() method is ignored in correctly deployed JavaFX application.
     * main() serves only as fallback in case the application can not be
     * launched through deployment artifacts, e.g., in IDEs with limited FX
     * support. NetBeans ignores main().
     *
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // launch the program
        launch(args);
    }
}
