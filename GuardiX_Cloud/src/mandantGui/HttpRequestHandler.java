//============================================================================
// 
// Author      : Li, Yuan
// File        : HttpRequestHandler.java
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 2.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     HttpRequestHandler.java is the handler of all HTTP requests, here we use
// POST requset to realize the communication between Mandant GUI and php backend
// . The Apache HttpComponents is responsible for creating and maintaining a 
// toolset of low level Java components focused on HTTP and associated protocols
// . For the authentication we use cookies to store session informations, and 
// send these session informations with requests to backend instead of sending 
// certificates everytime. In this way we should delete all session informations
// after finish the GUI progress for security reasons. That should be setted up 
// in php backend. 
//
//============================================================================

package mandantGui;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.CookieStore;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.protocol.ClientContext;
import org.apache.http.impl.client.BasicCookieStore;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.BasicHttpContext;
import org.apache.http.protocol.HttpContext;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.JSONValue;

/**
 * class HttpRequestHandler
 * Handler center for all post requests
 * Get all request from Java GUI and send them to PHP backend
 * Get Post Responds from PHP backend and forward to Java GUI
 * @author Li, Yuan
 */
public class HttpRequestHandler {
    
    // Http Client instance, use apache http client to send http request
    private final HttpClient client = new DefaultHttpClient();
    // cookie instance to store session parameters
    //  used here for authentication
    private final CookieStore cookieStore = new BasicCookieStore();
    // store session parameters which will be sent to backend with post request data
    private final HttpContext httpContext = new BasicHttpContext();
    // store mandant informations in form of Json
    private JSONObject Mandant_Information;
    // USER_AGENT 
    private final String USER_AGENT = "Mozilla/5.0";
    // URL to send request
    private String sURL;
    // construct
    // link cookie to http context
    public HttpRequestHandler(String URL) {
        sURL=URL;
        httpContext.setAttribute(ClientContext.COOKIE_STORE, cookieStore);
    }
    
    // get client list from backend by sending post request
    public JSONArray getUserList() throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_get_user";
        // write post data
        List<NameValuePair> urlParameters = new ArrayList<>();
        //urlParameters.add(new BasicNameValuePair("id", Mandant_Information.get("mandant_id").toString()));        
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);        
        // convert the StringBuilder to JSON
        Object obj = JSONValue.parse(content.toString());
        JSONArray finalResult = (JSONArray) obj;
        return finalResult;
    }
    
    // get client list from backend by sending post request
    public JSONArray getClientList() throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_get_clientList";
        // write post data
        List<NameValuePair> urlParameters = new ArrayList<>();
        //urlParameters.add(new BasicNameValuePair("id", Mandant_Information.get("mandant_id").toString()));        
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);        
        // convert the StringBuilder to JSON
        Object obj = JSONValue.parse(content.toString());
        JSONArray finalResult = (JSONArray) obj;
        return finalResult;
    }

    // get mandant information from backend by sending post request
    public JSONObject getMandantInformation() throws Exception {
        return Mandant_Information;
    }
    
    // get client permission list from backend by sending post request
    public JSONArray getClientPermission() throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_get_client_permission";
        // write post data
        List<NameValuePair> urlParameters = new ArrayList<>();
        //urlParameters.add(new BasicNameValuePair("id", Mandant_Information.get("mandant_id").toString()));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        // convert the StringBuilder to JSON    
        Object obj = JSONValue.parse(content.toString());
        JSONArray finalResult = (JSONArray) obj;
        return finalResult;
    }
    
    // add a client permission record by sending post request
    public String addClientPermission(String sClientIDS, String sClientIDR, String sPermission) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_add_client_permission";
        // write post data
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("client_id_s", sClientIDS));
        urlParameters.add(new BasicNameValuePair("client_id_r", sClientIDR));
        urlParameters.add(new BasicNameValuePair("permission", sPermission));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }
    
    // delete a client permission record by sending post request
    public String delClientPermission(String sClientIDS, String sClientIDR, String sPermission) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_del_client_permission";     
        // write post data   
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("client_id_s", sClientIDS));
        urlParameters.add(new BasicNameValuePair("client_id_r", sClientIDR));
        urlParameters.add(new BasicNameValuePair("permission", sPermission));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }
    
    // edit a client permission record by sending post request
    public String editClientPermission(String sClientIDS, String sClientIDR, String sPermission, String sNewClientIDS, String sNewClientIDR, String sNewPermission) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_edit_client_permission";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("client_id_s", sClientIDS));
        urlParameters.add(new BasicNameValuePair("client_id_r", sClientIDR));
        urlParameters.add(new BasicNameValuePair("permission", sPermission));
        urlParameters.add(new BasicNameValuePair("new_client_id_s", sNewClientIDS));
        urlParameters.add(new BasicNameValuePair("new_client_id_r", sNewClientIDR));
        urlParameters.add(new BasicNameValuePair("new_permission", sNewPermission));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }

    // Send post request to backend in order to login 
    public boolean MandantLogin(String sUsername, String sPassword) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_login";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("username", sUsername));
        urlParameters.add(new BasicNameValuePair("password", sPassword));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        if ("error".equals(content.toString())) {
            return false;
        } else {
            // convert the StringBuilder to JSON    
            Object obj = JSONValue.parse(content.toString());
            Mandant_Information = (JSONObject) obj;
            return true;
        }
    }
    
    // activate a client
    public String actClient(String sClientID) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_actclient";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("id", sClientID));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }
    
    // deactivate a client
    public String deactClient(String sClientID) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_deactclient";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("id", sClientID));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }
    
    // change the mac of a client
    public String changeClientMAC(String sClientID, String sMAC) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_change_client_mac";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("id", sClientID));
        urlParameters.add(new BasicNameValuePair("mac", sMAC));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }    
    
    // add a mandant user
    public String addUser(String username, String password) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_add_user";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("username", username));
        urlParameters.add(new BasicNameValuePair("password", password));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        System.out.println(content.toString());
        return content.toString();
    }
    
    // edit a mandant user
    public String editUser(String sUserID, String username, String password) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_edit_user";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("user_id", sUserID));
        urlParameters.add(new BasicNameValuePair("username", username));
        urlParameters.add(new BasicNameValuePair("password", password));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        System.out.println(content.toString());
        return content.toString();
    }  
    
    // deactive a mandant user
    public String delUser(String sUserID) throws Exception {
        // post url
        String url = "http://"+sURL+"/mandant_api_del_user";    
        // write post data       
        List<NameValuePair> urlParameters = new ArrayList<>();
        urlParameters.add(new BasicNameValuePair("user_id", sUserID));
        // store the post responds into StringBuilder content
        StringBuilder content = sendPostRequest(url, urlParameters);
        return content.toString();
    }  
    
    // setting up the post instance and send it to backend    
    private StringBuilder sendPostRequest(String url, List<NameValuePair> urlParameters) throws IOException, UnsupportedEncodingException, IllegalStateException {

        // Http post instance for sending request
        HttpPost post = new HttpPost(url);
        // add http header
        post.setHeader("User-Agent", USER_AGENT);
        // set post data
        post.setEntity(new UrlEncodedFormEntity(urlParameters));
        // get post responds
        HttpResponse response = client.execute(post, httpContext);
               
        BufferedReader rd = new BufferedReader(
                new InputStreamReader(response.getEntity().getContent()));
        StringBuilder content = new StringBuilder();
        // convert responded data to StringBuilder
        String line;
        while (null != (line = rd.readLine())) {
            content.append(line);
        }
        return content;
    }
}
