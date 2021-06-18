package com.example.dyunicafe.models;

public class GetPictureResponse {
    boolean error;
    String message, photo;

    public GetPictureResponse(boolean error, String message, String photo) {
        this.error = error;
        this.message = message;
        this.photo = photo;
    }

    public boolean isError() {
        return error;
    }

    public String getMessage() {
        return message;
    }

    public String getPhoto() {
        return photo;
    }
}
