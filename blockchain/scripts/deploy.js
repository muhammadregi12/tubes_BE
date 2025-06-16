import hre from "hardhat";

async function main() {
  const iuran = hre.ethers.utils.parseEther("0.01"); // iuran 0.01 ETH
  const periode = 30; // periode 30 hari

  const Arisan = await hre.ethers.getContractFactory("Arisan");
  const arisan = await Arisan.deploy(iuran, periode);

  await arisan.deployed();

  console.log(`✅ Contract Arisan deployed to: ${arisan.address}`);
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
