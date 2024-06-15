<?php
/**
 * -------------------
 * CONFIGURATION START
 */
const HAND_ROCK = '🗿🗿🗿🗿🗿';
const HAND_PAPER = '🧻🧻🧻🧻🧻';
const HAND_SCISSORS = '✂✂✂✂✂';

const AGENT_HUMAN = 'human';
const AGENT_COMPUTER = 'computer';

const EXPLAIN_GAME_OUTCOME = true;

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

    return "$winnerHand $action $loserHand";
}

function show($message = "")
{
    echo $message . PHP_EOL;
}

function host($message)
{
    show("🧐Host: $message");
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

function getComputerPlayerHand()
{
    return getRandomHand();
}
/**
 * GAME MOVE FUNCTIONS START
 * -------------------------
 */

function playRockPaperScissors($rounds = 3)
{
    $roundResults = [];
    for ($i = 0; $i < $rounds; $i++) {
        $humanHand = getHumanPlayerHand();
        $computerHand = getComputerPlayerHand();

        $roundDetails = playOneRound($humanHand, $computerHand);
        $roundDetails['roundNumber'] = $i + 1;
        $roundResults[$i] = $roundDetails;
    }


    $roundWinners = array_filter(array_column($roundResults, 'roundWinner'));
    $roundWinnersResults = array_count_values($roundWinners);
    $humanResults = $roundWinnersResults[AGENT_HUMAN] ?? 0;
    $computerResults = $roundWinnersResults[AGENT_COMPUTER] ?? 0;

    if ($humanResults === $computerResults) {
        $winner = null;
    } else if ($humanResults > $computerResults) {
        $winner = AGENT_HUMAN;
    } else {
        $winner = AGENT_COMPUTER;
    }

    host("Welcome to the Rock, Paper, Scissors game!");
    host("Today, a 🎮Human 🎮 is facing off against a 👾Computer 👾!");
    show("--");
    if ($winner === null) {
        host("After $rounds exciting rounds of Rock Paper Scissors...");
        host("We have a tie!");
    } else if ($winner === AGENT_HUMAN) {
        host("And the winner is... ");
        host("The 🎮Human 🎮!");
    } else {
        host("And the winner is... ");
        host("The 👾Computer 👾!");
    }
    show("--");
    host(" The score is 🎮$humanResults to 👾$computerResults");
    show("--");
    host(" Let's give a round of applause to both contestants for their fantastic effort!");

    if (EXPLAIN_GAME_OUTCOME) {
        show();
        show("######");
        host("Now, let me explain why:");

        foreach ($roundResults as $roundResult) {
            explainRound($roundResult);
        }
    }
}

function explainRound($roundDetails)
{
    show();
    show("***");
    host("Round #{$roundDetails['roundNumber']}");
    host("Human chose {$roundDetails['humanHand']}, Computer chose {$roundDetails['computerHand']}");
    if ($roundDetails['roundWinner'] === null) {
        host("It's a tie because both players have the same choice.");
        return;
    }


    $reason = explainVictory($roundDetails['winnerHand'], $roundDetails['loserHand']);
    if ($roundDetails['roundWinner'] === AGENT_HUMAN) {
        host("Human wins this round because $reason");
    } else {
        host("Computer wins this round because $reason");
    }
}

function playOneRound($humanHand, $computerHand) {
    $roundResult = [
        'humanHand' => $humanHand,
        'computerHand' => $computerHand,
        'winnerHand' => null,
        'loserHand' => null,
        'roundWinner' => null,
    ];
    if ($humanHand === $computerHand) {
        return $roundResult;
    }

    $isPlayerWins = GAME_RULES[$humanHand] === $computerHand;
    if ($isPlayerWins) {
        $roundResult['winnerHand'] = $humanHand;
        $roundResult['loserHand'] = $computerHand;
        $roundResult['roundWinner'] = AGENT_HUMAN;
    } else {
        $roundResult['winnerHand'] = $computerHand;
        $roundResult['loserHand'] = $humanHand;
        $roundResult['roundWinner'] = AGENT_COMPUTER;
    }

    return $roundResult;
}

playRockPaperScissors();