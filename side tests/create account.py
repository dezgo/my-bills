import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC

class PythonMyBillsTestSuite(unittest.TestCase):

    def setUp(self):
#        self.driver = webdriver.Ie('/python27/scripts/iedriverserver')
		self.driver = webdriver.Chrome('/usr/bin/chromedriver')

    def test_open_site(self):
        driver = self.driver
        driver.get("http://192.168.33.10/index.php/home")

        self.assertIn("my-bills", driver.title)
        
    def test_create_account(self):
        driver = self.driver
        driver.get("http://192.168.33.10/index.php/login")

    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()