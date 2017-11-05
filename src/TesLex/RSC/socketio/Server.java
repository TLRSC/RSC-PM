package tech.teslex.mpes.rsc.socketio;

import cn.nukkit.plugin.Plugin;
import com.corundumstudio.socketio.Configuration;
import com.corundumstudio.socketio.SocketIOServer;
import tech.teslex.mpes.rsc.Main;
import tech.teslex.mpes.rsc.console.Console;
import tech.teslex.mpes.rsc.console.RSCCommandSender;
import tech.teslex.mpes.rsc.socketio.models.RunCommand;

public class Server {

	private String host;
	private int port;
	private String secret;

	private Plugin plugin;

	private SocketIOServer server;

	public Server(String host, int port) {
		this.host = host;
		this.port = port;
	}

	public Server(String host, int port, Plugin plugin, String secret) {
		this.host = host;
		this.port = port;
		this.plugin = plugin;
		this.secret = secret;
	}

	public void start() {
		Configuration config = new Configuration();
		config.setHostname(host);
		config.setPort(port);

		server = new SocketIOServer(config);

		server.addConnectListener(socketIOClient -> {
			if (socketIOClient.getHandshakeData().getUrlParams().containsKey(secret)) {
				plugin.getLogger().info("Connected: " + socketIOClient.getRemoteAddress());
			} else {
				socketIOClient.sendEvent("auth_error", "Wrong secret");
				socketIOClient.disconnect();
			}
		});

		server.addDisconnectListener(socketIOClient -> {
			plugin.getLogger().info("Disconnected: " + socketIOClient.getRemoteAddress());
		});

		server.addEventListener("command", RunCommand.class, (socketIOClient, runCommand, ackRequest) -> {
			Console.dispachCommand(new RSCCommandSender(), runCommand.getCommand());
		});


		Console.addUpdateListener(text -> server.getBroadcastOperations().sendEvent("console", text));

		plugin.getLogger().info("§eStarting ws server..");
		server.startAsync();
	}

	public void stop() {
		plugin.getLogger().info("§eStopping ws server..");
		server.stop();
	}

	public SocketIOServer getServer() {
		return server;
	}
}
