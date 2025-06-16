// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

contract Arisan {
    address public admin;
    address[] public participants;
    mapping(address => bool) public hasPaid;
    address public lastWinner;

    uint public round = 1;
    uint public fee = 0.01 ether;

    constructor() {
        admin = msg.sender;
    }

    function join() public {
        require(!isParticipant(msg.sender), "Already joined");
        participants.push(msg.sender);
    }

    function pay() public payable {
        require(isParticipant(msg.sender), "Not a participant");
        require(msg.value == fee, "Wrong amount");
        hasPaid[msg.sender] = true;
    }

    function drawWinner() public {
        require(msg.sender == admin, "Only admin");
        require(allPaid(), "Not all paid");

        uint winnerIndex = uint(keccak256(abi.encodePacked(block.timestamp, block.difficulty))) % participants.length;
        lastWinner = participants[winnerIndex];

        payable(lastWinner).transfer(address(this).balance);

        for (uint i = 0; i < participants.length; i++) {
            hasPaid[participants[i]] = false;
        }

        round++;
    }

    function isParticipant(address user) public view returns (bool) {
        for (uint i = 0; i < participants.length; i++) {
            if (participants[i] == user) return true;
        }
        return false;
    }

    function allPaid() internal view returns (bool) {
        for (uint i = 0; i < participants.length; i++) {
            if (!hasPaid[participants[i]]) return false;
        }
        return true;
    }

    function getParticipants() public view returns (address[] memory) {
        return participants;
    }
}
