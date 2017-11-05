package tech.teslex.mpes.rsc.utils;

import com.auth0.jwt.JWTCreator.Builder;
import com.auth0.jwt.JWTVerifier;
import com.auth0.jwt.algorithms.Algorithm;
import com.auth0.jwt.interfaces.DecodedJWT;

import java.io.UnsupportedEncodingException;
import java.util.Date;
import java.util.Map;

public class JWT {

	public static String createToken(String sign, Map<String, Object> data) throws UnsupportedEncodingException {
		Algorithm algorithm = Algorithm.HMAC256(sign);
		Builder builder = com.auth0.jwt.JWT.create();

		data.forEach((v, c) -> {
			String clz = convertInstanceOfObject(c).getClass().getSimpleName();
			if (clz.equalsIgnoreCase("Integer"))
				builder.withClaim(v, Integer.parseInt(c.toString()));
			else if (clz.equalsIgnoreCase("String"))
				builder.withClaim(v, c.toString());
			else if (clz.equalsIgnoreCase("Date"))
				builder.withClaim(v, (Date) c);
			else if (clz.equalsIgnoreCase("Long"))
				builder.withClaim(v, Long.parseLong(c.toString()));
			else if (clz.equalsIgnoreCase("Double"))
				builder.withClaim(v, Double.parseDouble(c.toString()));
			else if (clz.equalsIgnoreCase("Boolean"))
				builder.withClaim(v, Boolean.parseBoolean(c.toString()));
		});

		return builder.sign(algorithm);
	}

	public static DecodedJWT verify(String token, String sign) throws UnsupportedEncodingException {
		Algorithm algorithm = Algorithm.HMAC256(sign);
		JWTVerifier verifier = com.auth0.jwt.JWT.require(algorithm)
				.build();
		return verifier.verify(token);
	}

	private static <T> T convertInstanceOfObject(Object o) {
		try {
			return (T) o;
		} catch (ClassCastException e) {
			return null;
		}
	}
}
