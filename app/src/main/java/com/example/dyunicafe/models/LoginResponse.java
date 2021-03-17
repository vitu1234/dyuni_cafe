package com.example.dyunicafe.models;

public class LoginResponse {

    private boolean error; //you can keep the variable name same as the json key object or use a different name and serialize
    private String message,file_url;//file_url is for file uploas
    private User user;

    public LoginResponse(boolean error, String message, User user) {
        this.error = error;
        this.message = message;
        this.user = user;
    }

    public boolean isError() {
        return error;
    }

    public String getMessage() {
        return message;
    }


    public User getUser() {
        return user;
    }
}
