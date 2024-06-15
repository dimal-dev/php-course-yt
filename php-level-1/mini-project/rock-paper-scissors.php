<?php
/**
 * -------------------
 * CONFIGURATION START
 */
const HAND_ROCK = '🗿🗿🗿🗿🗿';
const HAND_PAPER = '🧻🧻🧻🧻🧻';
const HAND_SCISSORS = '✂✂✂✂✂';

const PLAY_FOR_ME = false;
if (!PLAY_FOR_ME) {
    define('MY_HAND', HAND_ROCK);
} else {
    define('MY_HAND', null);
}

const HANDS = [
    HAND_ROCK,
    HAND_PAPER,
    HAND_SCISSORS,
];

const HAND_ACTION_LABEL = [
    HAND_ROCK => 'crushes',
    HAND_PAPER => 'covers',
    HAND_SCISSORS => 'cuts',
];

const GAME_RULES = [
    HAND_ROCK => HAND_SCISSORS,
    HAND_PAPER => HAND_ROCK,
    HAND_SCISSORS => HAND_PAPER,
];
/**
 * CONFIGURATION END
 * ----------------
 */

/**
 * ------
 * RENDER START
 */
function explainVictory($winnerHand, $loserHand)
{
    $action = HAND_ACTION_LABEL[$winnerHand];
    show("\t**");
    show("🧐 Because $winnerHand $action $loserHand");
}

function show($message)
{
    echo $message . PHP_EOL;
}
/**
 * RENDER END
 * ------
 */

/**
 * -----------------------
 * GAME MOVE FUNCTIONS END
 */
function getRandomHand()
{
    $index = array_rand(HANDS);

    return HANDS[$index];
}

function getHumanPlayerHand()
{
    return PLAY_FOR_ME ? getRandomHand() : MY_HAND;
}

function getComputerHand()
{
    return getRandomHand();
}
/**
 * GAME MOVE FUNCTIONS START
 * -------------------------
 */

function playRockPaperScissors()
{
    $playerHand = getHumanPlayerHand();
    $computerHand = getComputerPlayerHand();

    show("🎮 Player: {$playerHand}");
    show("\tVS");
    show("👾 Computer: {$computerHand}");
    show("\t--");

    if ($playerHand === $computerHand) {
        show("🥁 Outcome: Tie! 👔");

        return;
    }

    $isPlayerWins = GAME_RULES[$playerHand] === $computerHand;
    if ($isPlayerWins) {
        show("🥁 Outcome: 🥇🎮🥇wins! ");

        $winner = $playerHand;
        $loser = $computerHand;
    } else {
        show("🥁 Outcome: 🥇👾🥇wins! ");

        $winner = $computerHand;
        $loser = $playerHand;
    }

    explainVictory($winner, $loser);
}

playRockPaperScissors();