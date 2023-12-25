<style>
    .menu-item {
    cursor: pointer !important;
}

#live-chat {
    bottom: 0;
    font-size: 20px;
    /* left: 24px; */
    position: fixed;
    width: 430px;
    z-index: 9999;
    
}

#live-chat header {
    background: #0F253B;
    /* border-radius: 5px 5px 0 0; */
    color: #fff;
    cursor: pointer;
    padding: 3px;
}

#live-chat h4:before {
    background: #1a8a34;
    border-radius: 50%;
    content: "";
    height: 8px;
    margin: 0 8px 0 0;
    width: 8px;
}

#live-chat h4 {
    font-size: 13px;
    margin: 0;
    padding: 12px;
}

#live-chat input[type="text"] {
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 8px;
    outline: none;
    width: 234px;
}

.chat {
    background-color: #0F253B !important;
    border: 1px solid #ddd;
    padding: 2px 15px;
}

.chat-feedback {
    font-size: 18px;
    padding: 4px 3px;
    text-align: center;
    font-weight: bold;
}

.main-search-btn {
    transition: all .35s;
    background: orange;
    border: transparent;
    color: #fff;
    padding: 7px 16px;
}

.main-search-btn:hover {
    color: #fff;
}

/* width */
::-webkit-scrollbar {
width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
background: #555;
}
</style>