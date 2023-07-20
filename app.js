// App Bridge Init
var AppBridge = window['app-bridge'];
var config = {
    apiKey: "<?php echo $config['api_key']; ?>",
    host: new URLSearchParams(location.search).get("host"),
    forceRedirect: true
};  
var app = AppBridge.createApp(config);

// Actions
var TitleBar = AppBridge.actions.TitleBar;
var Toast = AppBridge.actions.Toast;
var Modal = AppBridge.actions.Modal;
var Button = AppBridge.actions.Button;

// Buttons
var modalButton = Button.create(app, {label: 'Modal'});
var toastButton = Button.create(app, {label: 'Toast'});

// Toast
var toastOptions = {
  message: 'Toast is up!',
  duration: 2000
};
var toastNotice = Toast.create(app, toastOptions);

// TitleBar
var titleBarOptions = {
  title: 'Welcome to App Bridge',
  buttons: {
    primary: modalButton,
    secondary: [toastButton]
  },
};
var myTitleBar = TitleBar.create(app, titleBarOptions);

// Authenticated Fetch
var authenticatedFetch = window["app-bridge"].utilities.authenticatedFetch(app);

// Toast Button Click
toastButton.subscribe(Button.Action.CLICK, data => {
    toastNotice.dispatch(Toast.Action.SHOW);
});

// Modal Button Click
modalButton.subscribe(Button.Action.CLICK, data => {
    authenticatedFetch('/modal.json').then(function(response) {
        return response.json();
    }).then(function(modalOptions) {

        var myModal = Modal.create(app, modalOptions);
        myModal.dispatch(Modal.Action.OPEN);

    })
})