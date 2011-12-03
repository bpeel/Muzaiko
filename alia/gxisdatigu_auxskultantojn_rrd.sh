#!/usr/bin/env bash

RRD_FILE_NAME='/var/muzaiko/auxskultantoj.rrd'
RRDTOOL='rrdtool'
CURRENT_TIMESTAMP=$(date '+%s')

if [ ! -f ${RRD_FILE_NAME} ]
then
	STEP=60
	VARIABLE_NAME='auxskultantoj'
	DATA_SOURCE_TYPE='GAUGE'
	HEARTBEAT=$((STEP * 2))
	MIN_VALUE=0
	MAX_VALUE=U

	MINUTE_CONSOLIDATION_FUNCTION='AVERAGE'
	MINUTE_XFF=0.5
	MINUTE_STEP=1
	MINUTE_ROWS=1440 # high resolution day

	FIVE_MINUTES_CONSOLIDATION_FUNCTION='AVERAGE'
	FIVE_MINUTES_XFF=0.5
	FIVE_MINUTES_STEP=5
	FIVE_MINUTES_ROWS=2016 # high resolution week

	FIFTEEN_MINUTES_CONSOLIDATION_FUNCTION='AVERAGE'
	FIFTEEN_MINUTES_XFF=0.5
	FIFTEEN_MINUTES_STEP=15
	FIFTEEN_MINUTES_ROWS=3976 # high resolution month

	HOUR_CONSOLIDATION_FUNCTION='AVERAGE'
	HOUR_XFF=0.5
	HOUR_STEP=60
	HOUR_ROWS=8784 # high resolution year

	DAY_CONSOLIDATION_FUNCTION='AVERAGE'
	DAY_XFF=0.5
	DAY_STEP=1440
	DAY_ROWS=3660 # high resolution decade

	${RRDTOOL} create "${RRD_FILE_NAME}" \
		--step "${STEP}" \
		"DS:${VARIABLE_NAME}:${DATA_SOURCE_TYPE}:${HEARTBEAT}:${MIN_VALUE}:${MAX_VALUE}" \
		"RRA:${MINUTE_CONSOLIDATION_FUNCTION}:${MINUTE_XFF}:${MINUTE_STEP}:${MINUTE_ROWS}" \
		"RRA:${FIVE_MINUTES_CONSOLIDATION_FUNCTION}:${FIVE_MINUTES_XFF}:${FIVE_MINUTES_STEP}:${FIVE_MINUTES_ROWS}" \
		"RRA:${FIFTEEN_MINUTES_CONSOLIDATION_FUNCTION}:${FIFTEEN_MINUTES_XFF}:${FIFTEEN_MINUTES_STEP}:${FIFTEEN_MINUTES_ROWS}" \
		"RRA:${HOUR_CONSOLIDATION_FUNCTION}:${HOUR_XFF}:${HOUR_STEP}:${HOUR_ROWS}" \
		"RRA:${DAY_CONSOLIDATION_FUNCTION}:${DAY_XFF}:${DAY_STEP}:${DAY_ROWS}"
fi

[ -w "${RRD_FILE_NAME}" ] || exit 1

CURL='curl'

URL="http://api.radionomy.com/currentaudience.cfm?radiouid=14694a7d-9023-4db1-86b4-d85d96cba181"

AUXSKULTANTOJ=$(${CURL} --silent "${URL}")

${RRDTOOL} update "${RRD_FILE_NAME}" ${CURRENT_TIMESTAMP}:${AUXSKULTANTOJ}

