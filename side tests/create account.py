import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC

class PythonMyBillsTestSuite(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Ie('/python27/scripts/iedriverserver')

    def test_create_account(self):
        driver = self.driver
        driver.get("http://192.168.33.10/index.php/home")

        self.assertIn("my-bills", driver.title)
        
        elem = driver.find_element_by_name("q")
        elem.send_keys("pycon")
        elem.send_keys(Keys.RETURN)
        assert "No results found." not in driver.page_source


    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()