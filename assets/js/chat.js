import React, { useState } from "react";
import axios from "axios";
import Video from "twilio-video";

const Chat = () => {
  const [roomName, setRoomName] = useState("");
  const [hasJoinedRoom, setHasJoinedRoom] = useState(false);

  const joinChat = (event) => {
    event.preventDefault();
    if (roomName) {
      axios
        .post("/access_token", { roomName })
        .then((response) => {
          connectToRoom(response.data.token);
          setHasJoinedRoom(true);
          setRoomName("");
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      alert("You need to enter a room name");
    }
  };

  return (
    <div className="container">
      <div className={"col-md-12"}>
        <h1 className="text-title">Symfony React Video Chat</h1>
      </div>

      <div className="col-md-6">
        <div className={"mb-5 mt-5"}>
          {!hasJoinedRoom && (
            <form className="form-inline" onSubmit={joinChat}>
              <input
                type="text"
                name={"roomName"}
                className={"form-control"}
                id="roomName"
                placeholder="Enter a room name"
                value={roomName}
                onChange={(event) => setRoomName(event.target.value)}
              />

              <button type="submit" className="btn btn-primary">
                Join Room
              </button>
            </form>
          )}
        </div>
        <div id="video-chat-window"></div>
      </div>
    </div>
  );
};
const Chat = () => {
  const connectToRoom = (token) => {
    const { connect, createLocalVideoTrack } = Video;

    let connectOption = { name: roomName };

    connect(token, connectOption).then(
      (room) => {
        console.log(`Successfully joined a Room: ${room}`);

        const videoChatWindow = document.getElementById("video-chat-window");

        createLocalVideoTrack().then((track) => {
          videoChatWindow.appendChild(track.attach());
        });

        room.on("participantConnected", (participant) => {
          console.log(`Participant "${participant.identity}" connected`);

          participant.tracks.forEach((publication) => {
            if (publication.isSubscribed) {
              const track = publication.track;
              videoChatWindow.appendChild(track.attach());
            }
          });

          participant.on("trackSubscribed", (track) => {
            videoChatWindow.appendChild(track.attach());
          });
        });
      },
      (error) => {
        console.error(`Unable to connect to Room: ${error.message}`);
      }
    );
  };
};

export default Chat;
