package mandantGui;

import java.io.File;
import org.ini4j.Wini;

//============================================================================
// 
// Author      : Li, Yuan
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 1.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     CConfig Class is used for checking config file, and get parameter from
// it. This Class use "ini4j" library for implementation. Now it can only get
// URL from config file. When some other functions are required, it can be 
// modified easily.
//============================================================================


/**
 * CConfig Class is used for checking config file, and get parameter from
 * it.
 * @author abysmli
 */
public class CConfig {
    // Wini instance from "ini4j" library
    private Wini ini;
    // URL
    private String sURL;
    
    // constructor
    // setup Wini and call setURL() method to get URL from config file 
    public CConfig(String sConfigFilename) throws Exception {
        // setup Wini
        // sConfigFilename is the config filename
        // by default sConfigFilename = "config.ini"
        ini = new Wini(new File(sConfigFilename));
        
        // get URL
        setURL();
    }
    
    // get URL from config file 
    private void setURL() {
        // get URL
        sURL = ini.get("URL","backend");
    }
    
    // return URL
    public String getURL() {
        return sURL;
    }
}
