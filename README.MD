<h1>PHP Web Application</h1> <br>

<p>I tried to refactor the existing code from classroom into a better structure, though it still lacks proper
PSR Router and Container implementations </p>


<h2 id="file-structure">File Structure</h2>

<ul>
    <li><code>views/</code>: Contains view templates used by the application.</li>
    <li><code>App/</code>: Directory for application-specific classes.</li>
    <li><code>App/services/</code>: Directory for database operations and other functionalities.</li>
    <li><code>index.php</code>: Main entry point for the application.</li>
    <li><code>error.php</code>: Error page template.</li>
</ul>


<h2 id="file-structure">Code structure</h2>

<ul>
    <li><code>index.php</code>: This is the file that bootstraps my application, I'm redirecting all traffic through this file while using a custom query param "action" for every user action.
                                It also contains a basic class auto loader</li>
    <li><code>App.php</code>: Starts the session and provides the PDO class as a static property.</li>
    <li><code>Auth.php</code>: Contains session-based authentication methods .</li>
    <li><code>Session.php</code>: A wrapper class around the $_SESSION super-global.</li>
    <li><code>View.php</code>: It is a primitive templating engine that allows me to render views and inject custom params in them.</li>
</ul>
